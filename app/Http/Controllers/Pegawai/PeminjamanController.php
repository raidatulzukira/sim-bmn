<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\AsetBmn;
use App\Http\Requests\StorePeminjamanRequest;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $peminjamans = Peminjaman::with('asetBmn')
            ->where('user_id', auth()->id())
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pegawai.peminjaman.index', compact('peminjamans', 'status'));
    }

    public function create()
    {
        $asets = AsetBmn::where('status', 'tersedia')->orderBy('nama_aset')->get();
        return view('pegawai.peminjaman.create', compact('asets'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Peminjaman::create($validated);

        return redirect()->route('pegawai.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim dan sedang menunggu persetujuan Kasubag TU.');
    }

    public function show(Peminjaman $peminjaman)
    {
        // Pastikan hanya bisa melihat miliknya sendiri
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $peminjaman->load(['asetBmn', 'approver']);

        return view('pegawai.peminjaman.show', compact('peminjaman'));
    }
}
