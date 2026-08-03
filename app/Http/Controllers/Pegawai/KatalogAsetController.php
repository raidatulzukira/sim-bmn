<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\AsetBmn;
use Illuminate\Http\Request;

class KatalogAsetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('jenis_bmn'); // Using jenis_bmn for filter

        $asets = AsetBmn::select(
                \DB::raw('MAX(id) as id'),
                'kode_barang', 'nama_barang', 'merk', 'tipe', 'nama', 'jenis_bmn',
                \DB::raw('COUNT(id) as total_stok'),
                \DB::raw('SUM(CASE WHEN status = "tersedia" THEN 1 ELSE 0 END) as stok_tersedia'),
                \DB::raw('SUM(CASE WHEN status IN ("dipinjam", "menunggu_persetujuan", "menunggu_serah_terima") THEN 1 ELSE 0 END) as stok_dipinjam_dan_diproses'),
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
            ->havingRaw('SUM(CASE WHEN status = "tersedia" THEN 1 ELSE 0 END) > 0')
            ->orderBy('max_tanggal_perolehan', 'desc')
            ->orderBy('kode_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pegawai.katalog.index', compact('asets', 'search', 'kategori'));
    }

    public function show(AsetBmn $katalog_aset)
    {
        $katalog_aset->load('ruangan');
        return view('pegawai.katalog.show', compact('katalog_aset'));
    }
}
