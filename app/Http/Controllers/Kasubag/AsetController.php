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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kasubag.aset.index', compact('asets', 'search'));
    }

    public function show(AsetBmn $aset)
    {
        $aset->load('ruangan');
        return view('kasubag.aset.show', compact('aset'));
    }
}
