<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPeminjamanPending = Peminjaman::where('status', 'pending')->count();
        $jumlahPemeliharaanPending = Pemeliharaan::where('status', 'pending')->count();
        $jumlahPending = $jumlahPeminjamanPending + $jumlahPemeliharaanPending;

        return view('kasubag.dashboard', compact('jumlahPending', 'jumlahPeminjamanPending', 'jumlahPemeliharaanPending'));
    }
}
