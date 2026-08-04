<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pemeliharaan;
use App\Models\AsetBmn;
use App\Http\Requests\StoreLaporanKerusakanRequest;
use Illuminate\Http\Request;

class LaporanKerusakanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $batchQuery = Pemeliharaan::select(\Illuminate\Support\Facades\DB::raw('MAX(id) as max_id'))
            ->where('dilaporkan_oleh', auth()->id())
            ->where('jenis', 'situasional')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->groupBy('batch_id');

        $laporans = Pemeliharaan::with('asetBmn')
            ->whereIn('id', $batchQuery)
            ->addSelect(['*', 'total_barang' => Pemeliharaan::selectRaw('COUNT(*)')->from('pemeliharaan as p_sub')->whereColumn('p_sub.batch_id', 'pemeliharaan.batch_id')
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pegawai.pemeliharaan.index', compact('laporans', 'status'));
    }

    public function create()
    {
        return view('pegawai.pemeliharaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_kerusakan' => 'required|string',
        ]);
        
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pemeliharaan', 'public');
        }

        // Simpan sebagai laporan situasional dengan aset_id null
        $pemeliharaan = Pemeliharaan::create([
            'batch_id' => (string) \Illuminate\Support\Str::uuid(),
            'aset_id' => null,
            'jenis' => 'situasional',
            'dilaporkan_oleh' => auth()->id(),
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'foto' => $fotoPath,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        \App\Jobs\SendMaintenanceNotificationJob::dispatch($pemeliharaan->id);

        return redirect()->route('pegawai.laporan_kerusakan.index')
            ->with('success', 'Laporan kerusakan berhasil dikirim dan menunggu validasi Kasubag TU.');
    }

    public function show(Pemeliharaan $laporan_kerusakan)
    {
        // Pastikan laporan ini milik pegawai yang bersangkutan
        if ($laporan_kerusakan->dilaporkan_oleh !== auth()->id() || $laporan_kerusakan->jenis !== 'situasional') {
            abort(403, 'Akses ditolak.');
        }

        $laporan_kerusakan->load(['asetBmn', 'approver']);
        $batch = Pemeliharaan::with('asetBmn')->where('batch_id', $laporan_kerusakan->batch_id)->get();

        return view('pegawai.pemeliharaan.show', compact('laporan_kerusakan', 'batch'));
    }
}
