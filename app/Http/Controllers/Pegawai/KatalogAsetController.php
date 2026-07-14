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

        $asets = AsetBmn::with('ruangan')
            ->when($search, function($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%")
                             ->orWhere('kode_barang', 'like', "%{$search}%")
                             ->orWhere('merk', 'like', "%{$search}%");
            })
            ->when($kategori, function($query, $kategori) {
                return $query->where('jenis_bmn', $kategori);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pegawai.katalog.index', compact('asets', 'search', 'kategori'));
    }

    public function show(AsetBmn $katalog_aset)
    {
        $katalog_aset->load('ruangan');
        return view('pegawai.katalog.show', compact('katalog_aset'));
    }
}
