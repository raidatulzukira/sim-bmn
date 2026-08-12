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
                \DB::raw('SUM(CASE WHEN status = "dipinjam" THEN 1 ELSE 0 END) as stok_dipinjam'),
                \DB::raw('SUM(CASE WHEN status = "menunggu_persetujuan" THEN 1 ELSE 0 END) as stok_menunggu_persetujuan'),
                \DB::raw('SUM(CASE WHEN status = "menunggu_serah_terima" THEN 1 ELSE 0 END) as stok_menunggu_serah_terima'),
                \DB::raw('SUM(CASE WHEN status = "servis" THEN 1 ELSE 0 END) as stok_servis'),
                \DB::raw('SUM(CASE WHEN status = "menunggu_servis" THEN 1 ELSE 0 END) as stok_menunggu_servis'),
                \DB::raw('MIN(CAST(nup AS UNSIGNED)) as nup_awal'),
                \DB::raw('MAX(CAST(nup AS UNSIGNED)) as nup_akhir'),
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

        $jenis_bmn_list = AsetBmn::select('jenis_bmn')->distinct()->whereNotNull('jenis_bmn')->orderBy('jenis_bmn')->pluck('jenis_bmn');

        return view('pegawai.katalog.index', compact('asets', 'search', 'kategori', 'jenis_bmn_list'));
    }

    public function show(AsetBmn $katalog_aset)
    {
        $katalog_aset->load('ruangan');
        
        $semua_nup = AsetBmn::with('ruangan')
            ->where('kode_barang', $katalog_aset->kode_barang)
            ->where('nama_barang', $katalog_aset->nama_barang)
            ->where('merk', $katalog_aset->merk)
            ->where('tipe', $katalog_aset->tipe)
            ->where('nama', $katalog_aset->nama)
            ->orderByRaw('CAST(nup AS UNSIGNED)')
            ->get(['nup', 'status', 'ruangan_id']);
            
        $total_stok = $semua_nup->count();
        $stok_tersedia = $semua_nup->where('status', 'tersedia')->count();
        $stok_dipinjam = $semua_nup->where('status', 'dipinjam')->count();
        $stok_menunggu_persetujuan = $semua_nup->where('status', 'menunggu_persetujuan')->count();
        $stok_menunggu_serah_terima = $semua_nup->where('status', 'menunggu_serah_terima')->count();
        $stok_menunggu_servis = $semua_nup->where('status', 'menunggu_servis')->count();
        $stok_servis = $semua_nup->where('status', 'servis')->count();
            
        return view('pegawai.katalog.show', compact(
            'katalog_aset', 'semua_nup', 'total_stok', 'stok_tersedia', 
            'stok_dipinjam', 'stok_menunggu_persetujuan', 'stok_menunggu_serah_terima', 
            'stok_menunggu_servis', 'stok_servis'
        ));
    }
}
