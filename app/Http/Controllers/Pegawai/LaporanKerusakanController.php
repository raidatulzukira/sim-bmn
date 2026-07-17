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

        $laporans = Pemeliharaan::with('asetBmn')
            ->where('dilaporkan_oleh', auth()->id())
            ->where('jenis', 'situasional')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pegawai.pemeliharaan.index', compact('laporans', 'status'));
    }

    public function create()
    {
        // Aset yang bisa dilaporkan adalah aset yang tidak sedang dalam perbaikan
        $asets = AsetBmn::where('status', '!=', 'servis')->orderBy('nama_barang')->get();
        return view('pegawai.pemeliharaan.create', compact('asets'));
    }

    public function store(StoreLaporanKerusakanRequest $request)
    {
        $validated = $request->validated();
        
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pemeliharaan', 'public');
        }

        // Simpan sebagai laporan situasional
        $pemeliharaan = Pemeliharaan::create([
            'aset_id' => $validated['aset_id'],
            'jenis' => 'situasional',
            'dilaporkan_oleh' => auth()->id(),
            'deskripsi_kerusakan' => $validated['deskripsi_kerusakan'],
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

        return view('pegawai.pemeliharaan.show', compact('laporan_kerusakan'));
    }
}
