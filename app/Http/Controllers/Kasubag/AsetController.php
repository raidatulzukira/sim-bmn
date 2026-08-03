<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use App\Models\AsetBmn;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $asets = AsetBmn::with('ruangan')
            ->when($search, function($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%")
                             ->orWhere('kode_barang', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_perolehan', 'desc')
            ->orderBy('kode_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('kasubag.aset.index', compact('asets', 'search'));
    }

    public function rekap(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('jenis_bmn');

        $asets = AsetBmn::select(
                'kode_barang', 'nama_barang', 'merk', 'tipe', 'nama', 'jenis_bmn',
                \DB::raw('COUNT(id) as total_stok'),
                \DB::raw('SUM(CASE WHEN status = "tersedia" THEN 1 ELSE 0 END) as stok_tersedia'),
                \DB::raw('SUM(CASE WHEN status = "dipinjam" THEN 1 ELSE 0 END) as stok_dipinjam'),
                \DB::raw('SUM(CASE WHEN status = "menunggu_persetujuan" THEN 1 ELSE 0 END) as stok_menunggu_persetujuan'),
                \DB::raw('SUM(CASE WHEN status = "menunggu_serah_terima" THEN 1 ELSE 0 END) as stok_menunggu_serah_terima'),
                \DB::raw('SUM(CASE WHEN status IN ("servis", "menunggu_servis") THEN 1 ELSE 0 END) as stok_maintenance'),
                \DB::raw('MIN(nup) as nup_awal'),
                \DB::raw('MAX(nup) as nup_akhir'),
                \DB::raw('MAX(tanggal_perolehan) as max_tanggal_perolehan')
            )
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('kode_barang', 'like', "%{$search}%")
                      ->orWhere('merk', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function($query, $kategori) {
                return $query->where('jenis_bmn', $kategori);
            })
            ->groupBy('kode_barang', 'nama_barang', 'merk', 'tipe', 'nama', 'jenis_bmn')
            ->orderBy('max_tanggal_perolehan', 'desc')
            ->orderBy('kode_barang', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('kasubag.aset.rekap', compact('asets', 'search', 'kategori'));
    }

    public function show(AsetBmn $aset)
    {
        $aset->load('ruangan');
        return view('kasubag.aset.show', compact('aset'));
    }
}
