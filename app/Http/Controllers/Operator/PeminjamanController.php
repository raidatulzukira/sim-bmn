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
        try {
            DB::transaction(function () use ($peminjaman) {
                $lockedPeminjaman = Peminjaman::where('id', $peminjaman->id)->lockForUpdate()->first();

                if ($lockedPeminjaman->status !== 'dipinjam') {
                    throw new \Exception('Status peminjaman tidak valid untuk dikonfirmasi kembali.');
                }

                $lockedPeminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali_aktual' => now()
                ]);

                // Update Aset status back to tersedia
                AsetBmn::where('id', $lockedPeminjaman->aset_id)->update(['status' => 'tersedia']);
            });

            // WA Notification
            $peminjaman->refresh();
            $pesan = "Pengembalian aset {$peminjaman->asetBmn->nama_aset} telah kami konfirmasi. Terima kasih!";
            if ($peminjaman->user->no_wa) {
                $this->waService->kirimPesan($peminjaman->user->no_wa, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            }

            return redirect()->route('operator.peminjaman.show', $peminjaman->id)->with('success', 'Peminjaman berhasil dikonfirmasi selesai.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function kirimReminder(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Hanya aset yang sedang dipinjam yang dapat dikirimi reminder.');
        }

        $pesan = "Peringatan! Waktu peminjaman aset {$peminjaman->asetBmn->nama_aset} Anda akan/telah habis pada {$peminjaman->tanggal_kembali_rencana->format('d M Y')}. Segera kembalikan aset tersebut ke Operator.";
        
        if ($peminjaman->user->no_wa) {
            $this->waService->kirimPesan($peminjaman->user->no_wa, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            return redirect()->back()->with('success', 'Reminder berhasil dikirim ke peminjam.');
        }

        return redirect()->back()->with('error', 'Peminjam tidak memiliki nomor WhatsApp yang terdaftar.');
    }
}
