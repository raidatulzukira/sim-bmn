<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $jumlahPending = Peminjaman::where('user_id', $userId)
            ->where('status', 'pending')
            ->distinct('batch_id')
            ->count('batch_id');

        $jumlahDipinjam = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->distinct('batch_id')
            ->count('batch_id');

        $jumlahLaporanDiproses = Pemeliharaan::where('dilaporkan_oleh', $userId)
            ->whereIn('status', ['pending', 'disetujui', 'proses'])
            ->count();

        return view('pegawai.dashboard', compact('jumlahPending', 'jumlahDipinjam', 'jumlahLaporanDiproses'));
    }
}
