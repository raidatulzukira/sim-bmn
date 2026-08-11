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

        // 4. Notifikasi/alert: daftar peminjaman yang mendekati tanggal_kembali_rencana (H-1)
        // dan belum berstatus 'dikembalikan'
        $batchQuery = Peminjaman::select(\Illuminate\Support\Facades\DB::raw('MAX(id) as max_id'))
            ->where('status', 'dipinjam')
            ->whereNotNull('tanggal_kembali_rencana')
            ->whereDate('tanggal_kembali_rencana', '<=', Carbon::now()->addDays(1))
            ->groupBy('batch_id');

        $alertPeminjaman = Peminjaman::with(['asetBmn', 'user'])
            ->whereIn('id', $batchQuery)
            ->addSelect(['*', 'total_barang' => Peminjaman::selectRaw('COUNT(*)')->from('peminjaman as p_sub')->whereColumn('p_sub.batch_id', 'peminjaman.batch_id')
            ])
            ->get();

        // 5. Notifikasi/alert: daftar pemeliharaan rutin yang statusnya pending, disetujui, atau proses
        $batchPemeliharaanQuery = Pemeliharaan::select(\Illuminate\Support\Facades\DB::raw('MAX(id) as max_id'))
            ->whereIn('status', ['pending', 'disetujui', 'proses'])
            ->groupBy('batch_id');

        $alertPemeliharaan = Pemeliharaan::with(['asetBmn', 'pelapor'])
            ->whereIn('id', $batchPemeliharaanQuery)
            ->addSelect(['*', 'total_barang' => Pemeliharaan::selectRaw('COUNT(*)')->from('pemeliharaan as p_sub')->whereColumn('p_sub.batch_id', 'pemeliharaan.batch_id')])
            ->latest()
            ->get();

        // 6. Notifikasi: daftar aset yang perlu servis rutin (H-7 atau terlewat)
        $asetMembutuhkanServisRaw = AsetBmn::whereNotNull('interval_servis_bulan')
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
            
        // Kelompokkan berdasarkan kode_barang
        $asetMembutuhkanServis = $asetMembutuhkanServisRaw->groupBy('kode_barang')->map(function ($items) {
            $first = $items->first();
            return (object) [
                'kode_barang' => $first->kode_barang,
                'nama_barang' => $first->nama_barang,
                'total_unit' => $items->count(),
                'contoh_aset' => $first, // Untuk kebutuhan link atau ID referensi
            ];
        })->values();

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
