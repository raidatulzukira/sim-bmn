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

        $pemeliharaans = Pemeliharaan::with(['asetBmn', 'pelapor'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($jenis, function ($query, $jenis) {
                return $query->where('jenis', $jenis);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('operator.pemeliharaan.index', compact('pemeliharaans', 'status', 'jenis'));
    }

    public function create()
    {
        // Operator hanya bisa mengajukan servis rutin untuk aset yang 'tersedia'
        $asets = AsetBmn::where('status', 'tersedia')->orderBy('nama_barang')->get();
        return view('operator.pemeliharaan.create', compact('asets'));
    }

    public function store(StoreServisRutinRequest $request)
    {
        $validated = $request->validated();
        
        $pemeliharaan = Pemeliharaan::create([
            'aset_id' => $validated['aset_id'],
            'jenis' => 'rutin',
            'dilaporkan_oleh' => auth()->id(),
            'deskripsi_kerusakan' => $validated['deskripsi_kerusakan'],
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        \App\Jobs\SendMaintenanceNotificationJob::dispatch($pemeliharaan->id);

        return redirect()->route('operator.pemeliharaan.index')
            ->with('success', 'Pengajuan servis rutin berhasil dikirim dan menunggu persetujuan Kasubag TU.');
    }

    public function show(Pemeliharaan $pemeliharaan)
    {
        $pemeliharaan->load(['asetBmn', 'pelapor', 'approver']);
        return view('operator.pemeliharaan.show', compact('pemeliharaan'));
    }

    public function proses(Request $request, Pemeliharaan $pemeliharaan)
    {
        try {
            DB::transaction(function () use ($pemeliharaan) {
                $lockedPemeliharaan = Pemeliharaan::where('id', $pemeliharaan->id)->lockForUpdate()->first();

                if ($lockedPemeliharaan->status !== 'disetujui') {
                    throw new \Exception('Hanya pengajuan berstatus disetujui yang dapat mulai diproses.');
                }

                // Cek status aset, pastikan belum dalam perbaikan lain (opsional tambahan keamanan)
                $aset = AsetBmn::where('id', $lockedPemeliharaan->aset_id)->lockForUpdate()->first();
                if ($aset->status === 'servis') {
                    throw new \Exception('Aset ini sudah dalam status servis.');
                }

                // Ubah status pemeliharaan menjadi proses
                $lockedPemeliharaan->update([
                    'status' => 'proses'
                ]);

                // Ubah status aset menjadi servis
                $aset->update([
                    'status' => 'servis'
                ]);
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
                $lockedPemeliharaan = Pemeliharaan::where('id', $pemeliharaan->id)->lockForUpdate()->first();

                if ($lockedPemeliharaan->status !== 'proses') {
                    throw new \Exception('Status pemeliharaan harus "proses" sebelum dapat diselesaikan.');
                }

                // Upload Nota
                $path = $request->file('nota_teknisi')->store('nota_servis', 'public');

                $lockedPemeliharaan->update([
                    'status' => 'selesai',
                    'tanggal_selesai' => now(),
                    'nota_teknisi' => $path
                ]);

                $updateData = ['status' => 'tersedia'];
                if ($lockedPemeliharaan->jenis === 'rutin') {
                    $updateData['tanggal_servis_terakhir'] = now();
                }

                // Ubah kembali status aset menjadi tersedia dan perbarui tanggal jika rutin
                AsetBmn::where('id', $lockedPemeliharaan->aset_id)->update($updateData);
            });

            // WA Notification jika itu situasional
            $pemeliharaan->refresh();
            if ($pemeliharaan->jenis === 'situasional' && $pemeliharaan->pelapor && $pemeliharaan->pelapor->no_wa) {
                $pesan = "Kabar baik! Perbaikan aset {$pemeliharaan->asetBmn->nama_aset} yang Anda laporkan telah SELESAI. Aset kini sudah dapat digunakan kembali.";
                $this->waService->kirimPesan($pemeliharaan->pelapor->no_wa, $pesan, $pemeliharaan->dilaporkan_oleh, 'pemeliharaan', $pemeliharaan->id);
            }

            return redirect()->route('operator.pemeliharaan.show', $pemeliharaan->id)
                ->with('success', 'Pemeliharaan berhasil diselesaikan. Status aset telah kembali menjadi "Tersedia".');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
