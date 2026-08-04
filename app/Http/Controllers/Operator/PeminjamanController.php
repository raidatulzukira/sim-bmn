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
            ->groupBy('batch_id');

        $peminjamans = Peminjaman::with(['user', 'asetBmn'])
            ->whereIn('id', $batchQuery)
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->addSelect(['*', 'total_barang' => Peminjaman::selectRaw('COUNT(*)')->from('peminjaman as p_sub')->whereColumn('p_sub.batch_id', 'peminjaman.batch_id')
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

                if ($batchPeminjaman->first()->status !== 'disetujui') {
                    throw new \Exception('Hanya pengajuan berstatus disetujui yang dapat diproses serah terima.');
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
        $batchTotal = Peminjaman::where('batch_id', $peminjaman->batch_id)->count();

        $request->validate([
            'foto_pengembalian' => 'required|image|max:2048',
            'jumlah_rusak' => 'nullable|integer|min:0|max:' . $batchTotal,
            'deskripsi_kerusakan' => 'required_if:jumlah_rusak,>0|nullable|string',
        ]);

        $jumlahRusak = (int) $request->input('jumlah_rusak', 0);

        try {
            DB::transaction(function () use ($request, $peminjaman, $jumlahRusak) {
                $batchPeminjaman = Peminjaman::where('batch_id', $peminjaman->batch_id)->lockForUpdate()->get();

                if ($batchPeminjaman->first()->status !== 'dipinjam') {
                    throw new \Exception('Status peminjaman tidak valid untuk dikonfirmasi kembali.');
                }

                $path = $request->file('foto_pengembalian')->store('pengembalian', 'public');
                
                $rusakCount = 0;
                $pemeliharaanBatchId = (string) \Illuminate\Support\Str::uuid();
                $firstPemeliharaanId = null;

                foreach ($batchPeminjaman as $item) {
                    $item->update([
                        'status' => 'dikembalikan',
                        'tanggal_kembali_aktual' => now(),
                        'foto_pengembalian' => $path
                    ]);

                    if ($rusakCount < $jumlahRusak) {
                        // Mark as menunggu_persetujuan and create Pemeliharaan
                        AsetBmn::where('id', $item->aset_id)->update(['status' => 'menunggu_persetujuan']);
                        
                        $pemeliharaan = \App\Models\Pemeliharaan::create([
                            'batch_id' => $pemeliharaanBatchId,
                            'aset_id' => $item->aset_id,
                            'jenis' => 'situasional', // Type laporan kerusakan
                            'dilaporkan_oleh' => $item->user_id, // Atas nama pegawai yang meminjam
                            'deskripsi_kerusakan' => $request->input('deskripsi_kerusakan'),
                            'foto' => $path, // Gunakan foto pengembalian sebagai bukti
                            'status' => 'pending',
                            'tanggal_pengajuan' => now(),
                        ]);
                        
                        if (!$firstPemeliharaanId) {
                            $firstPemeliharaanId = $pemeliharaan->id;
                        }
                        
                        $rusakCount++;
                    } else {
                        // Update Aset status back to tersedia
                        AsetBmn::where('id', $item->aset_id)->update(['status' => 'tersedia']);
                    }
                }
                
                // Dispatch WA notification ONCE for the whole batch
                if ($firstPemeliharaanId) {
                    \App\Jobs\SendMaintenanceNotificationJob::dispatch($firstPemeliharaanId);
                }
            });

            $msg = 'Peminjaman berhasil dikonfirmasi selesai beserta dokumentasi fotonya.';
            if ($jumlahRusak > 0) {
                $msg .= " Sebanyak {$jumlahRusak} unit otomatis dilaporkan rusak dan menunggu persetujuan Kasubag TU.";
            }

            return redirect()->route('operator.peminjaman.show', $peminjaman->id)->with('success', $msg);
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
