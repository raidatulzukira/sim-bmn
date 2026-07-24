<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\AsetBmn;
use App\Models\Peminjaman;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung total keseluruhan aset BMN
        $totalAset = AsetBmn::count();

        // 2. Jumlah aset dengan status 'dipinjam'
        $asetDipinjam = AsetBmn::where('status', 'dipinjam')->count();

        // 3. Jumlah aset dengan status 'servis'
        $asetServis = AsetBmn::where('status', 'servis')->count();

        // 4. Notifikasi/alert: daftar peminjaman yang mendekati tanggal_kembali_rencana (H-2)
        // dan belum berstatus 'dikembalikan'
        $alertPeminjaman = Peminjaman::with(['asetBmn', 'user'])
            ->where('status', '!=', 'dikembalikan')
            ->whereNotNull('tanggal_kembali_rencana')
            ->whereDate('tanggal_kembali_rencana', '<=', Carbon::now()->addDays(2))
            ->get();

        // 5. Notifikasi/alert: daftar pemeliharaan rutin yang statusnya pending atau proses
        $alertPemeliharaan = Pemeliharaan::with(['asetBmn', 'pelapor'])
            ->whereIn('status', ['pending', 'proses'])
            ->get();

        // 6. Notifikasi: daftar aset yang perlu servis rutin (H-30 atau terlewat)
        $asetMembutuhkanServis = AsetBmn::whereNotNull('interval_servis_tahun')
            ->whereNotNull('tanggal_servis_terakhir')
            ->where('status', 'tersedia')
            ->whereDoesntHave('pemeliharaan', function ($query) {
                $query->where('jenis', 'rutin')
                      ->whereIn('status', ['pending', 'disetujui', 'proses']);
            })
            ->get()
            ->filter(function($aset) {
                return $aset->is_servis_warning;
            });

        return view('operator.dashboard', compact(
            'totalAset',
            'asetDipinjam',
            'asetServis',
            'alertPeminjaman',
            'alertPemeliharaan',
            'asetMembutuhkanServis'
        ));
    }
}
