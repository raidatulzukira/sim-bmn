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
        $jumlahPeminjamanPending = Peminjaman::where('status', 'pending')->distinct('batch_id')->count('batch_id');
        $jumlahPemeliharaanPending = Pemeliharaan::where('status', 'pending')->whereNotNull('aset_id')->distinct('batch_id')->count('batch_id');
        $jumlahPending = $jumlahPeminjamanPending + $jumlahPemeliharaanPending;

        return view('kasubag.dashboard', compact('jumlahPending', 'jumlahPeminjamanPending', 'jumlahPemeliharaanPending'));
    }
}
