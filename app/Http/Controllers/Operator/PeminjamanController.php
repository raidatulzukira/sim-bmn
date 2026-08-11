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

        $batchQuery = Peminjaman::select(DB::raw('MAX(id) as max_id'))
            ->groupBy('batch_id', 'status');

        $peminjamans = Peminjaman::with(['user', 'asetBmn'])
            ->whereIn('id', $batchQuery)
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->addSelect(['*', 'total_barang' => Peminjaman::selectRaw('COUNT(*)')->from('peminjaman as p_sub')
                ->whereColumn('p_sub.batch_id', 'peminjaman.batch_id')
                ->whereColumn('p_sub.status', 'peminjaman.status')
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('operator.peminjaman.index', compact('peminjamans', 'status'));
    }

    public function show(Peminjaman $peminjaman)
    {
        $batch = Peminjaman::with(['user', 'asetBmn', 'approver'])->where('batch_id', $peminjaman->batch_id)->get();
        $peminjaman->load(['user', 'asetBmn', 'approver']);
        return view('operator.peminjaman.show', compact('peminjaman', 'batch'));
    }

    public function prosesSerahTerima(SerahTerimaRequest $request, Peminjaman $peminjaman)
    {
        try {
            DB::transaction(function () use ($request, $peminjaman) {
                $batchPeminjaman = Peminjaman::where('batch_id', $peminjaman->batch_id)->lockForUpdate()->get();

                $firstItem = $batchPeminjaman->first();
                if ($firstItem->status !== 'disetujui') {
                    throw new \Exception('Hanya pengajuan berstatus disetujui yang dapat diproses serah terima.');
                }

                $batasH1 = $firstItem->estimasi_waktu_pinjam->copy()->subDay()->startOfDay();
                if (now()->startOfDay()->lt($batasH1)) {
                    throw new \Exception('Proses serah terima hanya dapat dilakukan paling cepat H-1 dari tanggal estimasi pinjam.');
                }

                $path = $request->file('foto_serah_terima')->store('serah_terima', 'public');

                foreach ($batchPeminjaman as $item) {
                    $item->update([
                        'status' => 'dipinjam',
                        'tanggal_pinjam' => now(),
                        'foto_serah_terima' => $path
                    ]);

                    // Update Aset status to dipinjam
                    AsetBmn::where('id', $item->aset_id)->update(['status' => 'dipinjam']);
                }
            });

            // WA Notification
            $peminjaman->refresh();
            // $pesan = "Aset {$peminjaman->asetBmn->nama_aset} telah diserahkan kepada Anda. Harap kembalikan pada {$peminjaman->tanggal_kembali_rencana->format('d M Y')}.";
            // if ($peminjaman->user->no_wa) {
            //     $this->waService->kirimPesan($peminjaman->user->no_wa, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            // }

            return redirect()->route('operator.peminjaman.show', $peminjaman->id)->with('success', 'Proses serah terima berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function konfirmasiDikembalikan(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'foto_pengembalian' => 'required|image|max:2048',
            'aset_dikembalikan' => 'required|array|min:1',
            'aset_dikembalikan.*' => 'exists:aset_bmn,id',
            'tanggal_perpanjangan' => 'nullable|date|after_or_equal:today',
            'deskripsi_pengembalian' => 'nullable|string',
        ]);

        $dikembalikanIds = $request->input('aset_dikembalikan', []);
        $tanggalPerpanjangan = $request->input('tanggal_perpanjangan');
        $deskripsi = $request->input('deskripsi_pengembalian');

        try {
            DB::transaction(function () use ($request, $peminjaman, $dikembalikanIds, $tanggalPerpanjangan, $deskripsi) {
                $batchPeminjaman = Peminjaman::where('batch_id', $peminjaman->batch_id)
                    ->where('status', 'dipinjam')
                    ->lockForUpdate()->get();

                if ($batchPeminjaman->isEmpty()) {
                    throw new \Exception('Semua aset dalam peminjaman ini sudah dikembalikan.');
                }

                $path = $request->file('foto_pengembalian')->store('pengembalian', 'public');
                
                foreach ($batchPeminjaman as $item) {
                    if (in_array($item->aset_id, $dikembalikanIds)) {
                        $item->update([
                            'status' => 'dikembalikan',
                            'tanggal_kembali_aktual' => now(),
                            'foto_pengembalian' => $path,
                            'catatan_pengembalian' => $deskripsi
                        ]);

                        AsetBmn::where('id', $item->aset_id)->update(['status' => 'tersedia']);
                    } else {
                        if ($tanggalPerpanjangan) {
                            $item->update([
                                'tanggal_kembali_rencana' => $tanggalPerpanjangan
                            ]);
                        }
                    }
                }
            });

            return redirect()->route('operator.peminjaman.show', $peminjaman->id)->with('success', 'Pengembalian aset berhasil diproses.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sendReminder(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Hanya aset yang sedang dipinjam yang dapat dikirimi reminder.');
        }

        $totalBarang = Peminjaman::where('batch_id', $peminjaman->batch_id)->count();
        
        $pesan = "Halo pegawai atas nama {$peminjaman->user->name}, mengingatkan bahwa batas waktu pengembalian untuk peminjaman {$totalBarang} unit {$peminjaman->asetBmn->nama_barang} adalah pada tanggal {$peminjaman->tanggal_kembali_rencana->format('d M Y')}. Harap untuk segera dikembalikan ke ruangan Operator.";
        
        $phone = $peminjaman->user->no_wa;
        
        if ($phone) {
            $this->waService->kirimPesan($phone, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            return redirect()->back()->with('success', 'Notifikasi WhatsApp berhasil dikirim ke Pegawai');
        }

        return redirect()->back()->with('error', 'Peminjam tidak memiliki nomor WhatsApp yang terdaftar.');
    }
}
