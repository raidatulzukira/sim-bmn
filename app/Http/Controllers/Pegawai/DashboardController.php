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
            ->count();

        $jumlahDipinjam = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        $jumlahLaporanDiproses = Pemeliharaan::where('dilaporkan_oleh', $userId)
            ->whereIn('status', ['pending', 'disetujui', 'proses'])
            ->count();

        return view('pegawai.dashboard', compact('jumlahPending', 'jumlahDipinjam', 'jumlahLaporanDiproses'));
    }
}
