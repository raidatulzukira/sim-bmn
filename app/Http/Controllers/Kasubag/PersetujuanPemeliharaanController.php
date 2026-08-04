<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use App\Models\Pemeliharaan;
use App\Http\Requests\RejectPemeliharaanRequest;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersetujuanPemeliharaanController extends Controller
{
    public function __construct(protected WhatsappService $waService)
    {
    }

    public function index(Request $request)
    {
        $tab = $request->input('tab', 'pending'); // default tab

        $batchQuery = Pemeliharaan::select(\Illuminate\Support\Facades\DB::raw('MAX(id) as max_id'))
            ->when($tab === 'pending', function ($query) {
                return $query->where('status', 'pending');
            }, function ($query) {
                return $query->where('status', '!=', 'pending');
            })
            ->groupBy('batch_id');

        $pemeliharaans = Pemeliharaan::with(['asetBmn', 'pelapor'])
            ->whereIn('id', $batchQuery)
            ->addSelect(['*', 'total_barang' => Pemeliharaan::selectRaw('COUNT(*)')->from('pemeliharaan as p_sub')->whereColumn('p_sub.batch_id', 'pemeliharaan.batch_id')
            ])
            ->when($tab === 'pending', function ($q) {
                return $q->latest('tanggal_pengajuan');
            }, function ($q) {
                return $q->latest('updated_at');
            })
            ->paginate(10)
            ->withQueryString();

        return view('kasubag.pemeliharaan.index', compact('pemeliharaans', 'tab'));
    }

    public function show(Pemeliharaan $pemeliharaan)
    {
        $batch = Pemeliharaan::with(['asetBmn', 'pelapor'])
            ->where('batch_id', $pemeliharaan->batch_id)
            ->get();
            
        $pemeliharaan->load(['asetBmn', 'pelapor', 'approver']);
        return view('kasubag.pemeliharaan.show', compact('pemeliharaan', 'batch'));
    }

    public function approve(Request $request, Pemeliharaan $pemeliharaan)
    {
        try {
            DB::transaction(function () use ($pemeliharaan) {
                $lockedBatch = Pemeliharaan::where('batch_id', $pemeliharaan->batch_id)->lockForUpdate()->get();

                foreach ($lockedBatch as $item) {
                    if ($item->status !== 'pending') {
                        throw new \Exception('Salah satu pengajuan ini sudah diproses sebelumnya.');
                    }

                    $item->update([
                        'status' => 'disetujui',
                        'approved_by' => auth()->id(),
                    ]);

                    \App\Models\AsetBmn::where('id', $item->aset_id)->update(['status' => 'menunggu_servis']);
                }
            });

            // WA Notification (Hanya untuk situasional, rutin cukup internal)
            // $pemeliharaan->refresh();
            // if ($pemeliharaan->jenis === 'situasional' && $pemeliharaan->pelapor && $pemeliharaan->pelapor->no_wa) {
            //     // $pesan = "Halo, Laporan kerusakan untuk aset {$pemeliharaan->asetBmn->nama_barang} telah DISETUJUI. Operator akan segera menindaklanjuti perbaikannya.";
            //     // $this->waService->kirimPesan($pemeliharaan->pelapor->no_wa, $pesan, $pemeliharaan->dilaporkan_oleh, 'pemeliharaan', $pemeliharaan->id);
            // } else if ($pemeliharaan->jenis === 'rutin') {
            //     // Log internal (tanpa kirim WA ke peminjam karena tidak ada pelapor)
            //     $this->waService->kirimPesan('internal_log', "Servis rutin {$pemeliharaan->asetBmn->nama_barang} disetujui", auth()->id(), 'pemeliharaan', $pemeliharaan->id);
            // }

            return redirect()->route('kasubag.persetujuan_pemeliharaan.index')->with('success', 'Pengajuan pemeliharaan berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(RejectPemeliharaanRequest $request, Pemeliharaan $pemeliharaan)
    {
        try {
            DB::transaction(function () use ($request, $pemeliharaan) {
                $lockedBatch = Pemeliharaan::where('batch_id', $pemeliharaan->batch_id)->lockForUpdate()->get();

                foreach ($lockedBatch as $item) {
                    if ($item->status !== 'pending') {
                        throw new \Exception('Salah satu pengajuan ini sudah diproses sebelumnya.');
                    }

                    $item->update([
                        'status' => 'ditolak',
                        'approved_by' => auth()->id(),
                        'catatan_validasi' => $request->validated('catatan_validasi'),
                    ]);

                    \App\Models\AsetBmn::where('id', $item->aset_id)->update(['status' => 'tersedia']);
                }
            });

            // WA Notification
            // $pemeliharaan->refresh();
            // if ($pemeliharaan->jenis === 'situasional' && $pemeliharaan->pelapor && $pemeliharaan->pelapor->no_wa) {
            //     $pesan = "Mohon maaf, laporan kerusakan aset {$pemeliharaan->asetBmn->nama_barang} DITOLAK oleh Kasubag TU.\nAlasan: {$pemeliharaan->catatan_validasi}";
            //     $this->waService->kirimPesan($pemeliharaan->pelapor->no_wa, $pesan, $pemeliharaan->dilaporkan_oleh, 'pemeliharaan', $pemeliharaan->id);
            // } else if ($pemeliharaan->jenis === 'rutin') {
            //     $this->waService->kirimPesan('internal_log', "Servis rutin {$pemeliharaan->asetBmn->nama_barang} ditolak. Alasan: {$pemeliharaan->catatan_validasi}", auth()->id(), 'pemeliharaan', $pemeliharaan->id);
            // }

            return redirect()->route('kasubag.persetujuan_pemeliharaan.index')->with('success', 'Pengajuan pemeliharaan berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
