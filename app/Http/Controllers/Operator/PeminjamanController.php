<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\AsetBmn;
use App\Http\Requests\SerahTerimaRequest;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function __construct(protected WhatsappService $waService)
    {
    }

    public function index(Request $request)
    {
        $status = $request->input('status');

        $peminjamans = Peminjaman::with(['user', 'asetBmn'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('operator.peminjaman.index', compact('peminjamans', 'status'));
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'asetBmn', 'approver']);
        return view('operator.peminjaman.show', compact('peminjaman'));
    }

    public function prosesSerahTerima(SerahTerimaRequest $request, Peminjaman $peminjaman)
    {
        try {
            DB::transaction(function () use ($request, $peminjaman) {
                $lockedPeminjaman = Peminjaman::where('id', $peminjaman->id)->lockForUpdate()->first();

                if ($lockedPeminjaman->status !== 'disetujui') {
                    throw new \Exception('Hanya pengajuan berstatus disetujui yang dapat diproses serah terima.');
                }

                $path = $request->file('foto_serah_terima')->store('serah_terima', 'public');

                $lockedPeminjaman->update([
                    'status' => 'dipinjam',
                    'tanggal_pinjam' => now(),
                    'foto_serah_terima' => $path
                ]);

                // Update Aset status to dipinjam
                AsetBmn::where('id', $lockedPeminjaman->aset_id)->update(['status' => 'dipinjam']);
            });

            // WA Notification
            $peminjaman->refresh();
            $pesan = "Aset {$peminjaman->asetBmn->nama_aset} telah diserahkan kepada Anda. Harap kembalikan pada {$peminjaman->tanggal_kembali_rencana->format('d M Y')}.";
            if ($peminjaman->user->no_wa) {
                $this->waService->kirimPesan($peminjaman->user->no_wa, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            }

            return redirect()->route('operator.peminjaman.show', $peminjaman->id)->with('success', 'Proses serah terima berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function konfirmasiDikembalikan(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'foto_pengembalian' => 'required|image|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request, $peminjaman) {
                $lockedPeminjaman = Peminjaman::where('id', $peminjaman->id)->lockForUpdate()->first();

                if ($lockedPeminjaman->status !== 'dipinjam') {
                    throw new \Exception('Status peminjaman tidak valid untuk dikonfirmasi kembali.');
                }

                $path = $request->file('foto_pengembalian')->store('pengembalian', 'public');

                $lockedPeminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali_aktual' => now(),
                    'foto_pengembalian' => $path
                ]);

                // Update Aset status back to tersedia
                AsetBmn::where('id', $lockedPeminjaman->aset_id)->update(['status' => 'tersedia']);
            });

            // WA Notification
            $peminjaman->refresh();
            $pesan = "Pengembalian aset {$peminjaman->asetBmn->nama_barang} telah kami konfirmasi beserta dokumentasinya. Terima kasih!";
            if ($peminjaman->user->no_wa) {
                $this->waService->kirimPesan($peminjaman->user->no_wa, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            }

            return redirect()->route('operator.peminjaman.show', $peminjaman->id)->with('success', 'Peminjaman berhasil dikonfirmasi selesai beserta dokumentasi fotonya.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sendReminder(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Hanya aset yang sedang dipinjam yang dapat dikirimi reminder.');
        }

        $pesan = "Halo pegawai atas nama {$peminjaman->user->name}, mengingatkan bahwa batas waktu pengembalian untuk aset {$peminjaman->asetBmn->nama_barang} adalah pada tanggal {$peminjaman->tanggal_kembali_rencana->format('d M Y')}. Harap untuk segera dikembalikan ke ruangan Operator.";
        
        $phone = $peminjaman->user->no_wa;
        
        if ($phone) {
            try {
                // Format nomor untuk WAHA: ganti awalan 0 menjadi 62, lalu tambahkan @c.us
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                }
                
                if (!str_ends_with($phone, '@c.us')) {
                    $phone .= '@c.us';
                }

                $baseUrl = env('WAHA_BASE_URL', 'http://localhost:3000');
                $apiKey = env('WAHA_API_KEY', '');
                $wahaSession = env('WAHA_SESSION', 'default'); 

                $response = \Illuminate\Support\Facades\Http::timeout(5)
                    ->withHeaders([
                        'X-Api-Key' => $apiKey,
                        'Accept' => 'application/json',
                    ])
                    ->post($baseUrl . '/api/sendText', [
                        'chatId' => $phone,
                        'text' => $pesan,
                        'session' => $wahaSession
                    ]);

                if ($response->failed()) {
                    \Illuminate\Support\Facades\Log::error('WAHA Gateway Error (Reminder): ' . $response->body());
                    return redirect()->back()->with('error', 'Gagal mengirim notifikasi WhatsApp: Layanan tidak merespon dengan baik.');
                }
                
                return redirect()->back()->with('success', 'Notifikasi WhatsApp berhasil dikirim ke Pegawai');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('WAHA Gateway Exception (Reminder): ' . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Peminjam tidak memiliki nomor WhatsApp yang terdaftar.');
    }
}
