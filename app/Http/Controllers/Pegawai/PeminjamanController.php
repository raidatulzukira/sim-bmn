<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\AsetBmn;
use App\Models\User;
use App\Http\Requests\Pegawai\StorePeminjamanRequest;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $peminjamans = Peminjaman::with('asetBmn')
            ->where('user_id', auth()->id())
            ->when($search, function($query, $search) {
                return $query->whereHas('asetBmn', function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('kode_barang', 'like', "%{$search}%");
                })->orWhere('keperluan', 'like', "%{$search}%");
            })
            ->when($status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pegawai.peminjaman.index', compact('peminjamans', 'search', 'status'));
    }

    public function create()
    {
        $asets = AsetBmn::where('status', 'tersedia')->get();
        return view('pegawai.peminjaman.create', compact('asets'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        $peminjaman = Peminjaman::create([
            'aset_id' => $request->aset_id,
            'user_id' => auth()->id(),
            'keperluan' => $request->keperluan,
            'estimasi_waktu_pinjam' => $request->estimasi_waktu_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status' => 'pending',
        ]);

        // Mengambil nomor telepon dari Kasubag TU dan Operator
        $usersToNotify = User::whereIn('role', ['kasubag_tu', 'operator'])
            ->whereNotNull('no_wa')
            ->where('no_wa', '!=', '')
            ->get();

        $namaPegawai = auth()->user()->name;
        $namaAset = AsetBmn::where('id', $request->aset_id)->first()->nama_barang;
        $pesan = "Halo, terdapat pengajuan peminjaman aset baru dari pegawai {$namaPegawai}. Aset yang dipinjam adalah {$namaAset}. Mohon untuk segera diproses.";

        $waService = app(\App\Services\WhatsappService::class);

        foreach ($usersToNotify as $user) {
            if ($user->no_wa) {
                $waService->kirimPesan($user->no_wa, $pesan, $user->id, 'peminjaman', $peminjaman->id);
            }
        }

        return redirect()->route('pegawai.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman aset berhasil dikirim dan sedang menunggu persetujuan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        $peminjaman->load(['asetBmn.ruangan', 'approver']);
        return view('pegawai.peminjaman.show', compact('peminjaman'));
    }
}
