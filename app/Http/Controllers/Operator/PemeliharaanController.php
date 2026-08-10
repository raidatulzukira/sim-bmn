<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Pemeliharaan;
use App\Models\AsetBmn;
use App\Http\Requests\StoreServisRutinRequest;
use App\Http\Requests\SelesaiPemeliharaanRequest;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemeliharaanController extends Controller
{
    public function __construct(protected WhatsappService $waService)
    {
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $jenis = $request->input('jenis');

        // Gunakan batching logic
        $batchQuery = Pemeliharaan::select(\Illuminate\Support\Facades\DB::raw('MAX(id) as max_id'))
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($jenis, function ($query, $jenis) {
                return $query->where('jenis', $jenis);
            })
            ->groupBy('batch_id');

        $pemeliharaans = Pemeliharaan::with(['asetBmn', 'pelapor'])
            ->whereIn('id', $batchQuery)
            ->addSelect(['*', 'total_barang' => Pemeliharaan::selectRaw('COUNT(*)')->from('pemeliharaan as p_sub')->whereColumn('p_sub.batch_id', 'pemeliharaan.batch_id')
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('operator.pemeliharaan.index', compact('pemeliharaans', 'status', 'jenis'));
    }

    public function create(Request $request)
    {
        $kodeBarang = $request->input('kode_barang');
        $filter = $request->input('filter');
        
        $query = AsetBmn::where('status', 'tersedia');
        if ($kodeBarang) {
            $query->where('kode_barang', $kodeBarang);
        }

        if ($filter === 'rutin') {
            $query->whereNotNull('interval_servis_tahun')
                  ->whereNotNull('tanggal_servis_terakhir')
                  ->whereDoesntHave('pemeliharaan', function ($q) {
                      $q->where('jenis', 'rutin')
                        ->whereIn('status', ['pending', 'disetujui', 'proses']);
                  });
            
            $asets = $query->orderBy('nama_barang')->get()->filter(function($aset) {
                return $aset->is_servis_warning;
            })->values();
        } else {
            $asets = $query->orderBy('nama_barang')->get();
        }
        
        return view('operator.pemeliharaan.create', compact('asets', 'kodeBarang'));
    }

    public function store(StoreServisRutinRequest $request)
    {
        $validated = $request->validated();
        
        $batchId = (string) \Illuminate\Support\Str::uuid();
        $firstPemeliharaanId = null;

        DB::transaction(function () use ($validated, $batchId, &$firstPemeliharaanId) {
            foreach ($validated['aset_ids'] as $aset_id) {
                $pemeliharaan = Pemeliharaan::create([
                    'batch_id' => $batchId,
                    'aset_id' => $aset_id,
                    'jenis' => 'rutin',
                    'dilaporkan_oleh' => auth()->id(),
                    'deskripsi_kerusakan' => $validated['deskripsi_kerusakan'],
                    'status' => 'pending',
                    'tanggal_pengajuan' => now(),
                ]);

                if (!$firstPemeliharaanId) {
                    $firstPemeliharaanId = $pemeliharaan->id;
                }

                AsetBmn::where('id', $aset_id)->update(['status' => 'menunggu_persetujuan']);
            }
        });

        if ($firstPemeliharaanId) {
            \App\Jobs\SendMaintenanceNotificationJob::dispatch($firstPemeliharaanId);
        }

        return redirect()->route('operator.pemeliharaan.index')
            ->with('success', 'Pengajuan servis rutin berhasil dikirim dan menunggu persetujuan Kasubag TU.');
    }

    public function show(Pemeliharaan $pemeliharaan)
    {
        $batch = Pemeliharaan::with(['asetBmn', 'pelapor', 'approver'])
            ->where('batch_id', $pemeliharaan->batch_id)
            ->get();
            
        $pemeliharaan->load(['asetBmn', 'pelapor', 'approver']);
        
        $asets = null;
        if ($pemeliharaan->status === 'pending' && is_null($pemeliharaan->aset_id)) {
            $asets = AsetBmn::whereIn('status', ['tersedia', 'dipinjam'])->orderBy('nama_barang')->get();
        }
        return view('operator.pemeliharaan.show', compact('pemeliharaan', 'batch', 'asets'));
    }

    public function tentukanAset(Request $request, Pemeliharaan $pemeliharaan)
    {
        $request->validate([
            'aset_id' => 'required|exists:aset_bmn,id',
        ], [
            'aset_id.required' => 'Anda harus memilih aset BMN yang dimaksud.'
        ]);

        if ($pemeliharaan->status !== 'pending' || !is_null($pemeliharaan->aset_id)) {
            return redirect()->back()->with('error', 'Aset sudah ditentukan atau status tidak valid.');
        }

        DB::transaction(function () use ($request, $pemeliharaan) {
            $pemeliharaan->update([
                'aset_id' => $request->aset_id
            ]);
            
            // Dispatch notification to Kasubag TU now that aset_id is set
            \App\Jobs\SendMaintenanceNotificationJob::dispatch($pemeliharaan->id);
        });

        return redirect()->route('operator.pemeliharaan.show', $pemeliharaan->id)
            ->with('success', 'Aset berhasil ditentukan. Pengajuan telah diteruskan ke Kasubag TU untuk persetujuan.');
    }

    public function proses(Request $request, Pemeliharaan $pemeliharaan)
    {
        try {
            DB::transaction(function () use ($request, $pemeliharaan) {
                // If the report was made by Pegawai (aset_id null), they only submitted 1 record.
                // We lock the specific record. If it's a batch from operator, we lock all.
                $lockedBatch = Pemeliharaan::where('batch_id', $pemeliharaan->batch_id)->lockForUpdate()->get();

                foreach ($lockedBatch as $item) {
                    if ($item->status !== 'disetujui') {
                        throw new \Exception('Hanya pengajuan berstatus disetujui yang dapat mulai diproses.');
                    }

                    $aset_id = $item->aset_id;

                    if (is_null($aset_id)) {
                        throw new \Exception('Aset belum ditentukan untuk pemeliharaan ini.');
                    }

                    $aset = AsetBmn::where('id', $aset_id)->lockForUpdate()->first();
                    if ($aset->status === 'servis') {
                        throw new \Exception("Aset {$aset->nama_barang} sudah dalam status servis.");
                    }

                    $item->update([
                        'status' => 'proses',
                        'aset_id' => $aset_id
                    ]);

                    $aset->update([
                        'status' => 'servis'
                    ]);
                }
            });

            return redirect()->route('operator.pemeliharaan.show', $pemeliharaan->id)
                ->with('success', 'Pemeliharaan mulai diproses. Status aset berhasil diubah menjadi "Servis".');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function selesai(SelesaiPemeliharaanRequest $request, Pemeliharaan $pemeliharaan)
    {
        try {
            DB::transaction(function () use ($request, $pemeliharaan) {
                $lockedBatch = Pemeliharaan::where('batch_id', $pemeliharaan->batch_id)->lockForUpdate()->get();

                $path = $request->file('nota_teknisi')->store('nota_servis', 'public');

                foreach ($lockedBatch as $item) {
                    if ($item->status !== 'proses') {
                        throw new \Exception('Status pemeliharaan harus "proses" sebelum dapat diselesaikan.');
                    }

                    $item->update([
                        'status' => 'selesai',
                        'tanggal_selesai' => now(),
                        'nota_teknisi' => $path
                    ]);

                    $updateData = ['status' => 'tersedia'];
                    if ($item->jenis === 'rutin') {
                        $updateData['tanggal_servis_terakhir'] = now();
                    }

                    AsetBmn::where('id', $item->aset_id)->update($updateData);
                }
            });

            return redirect()->route('operator.pemeliharaan.show', $pemeliharaan->id)
                ->with('success', 'Pemeliharaan berhasil diselesaikan. Status aset telah kembali menjadi "Tersedia".');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
