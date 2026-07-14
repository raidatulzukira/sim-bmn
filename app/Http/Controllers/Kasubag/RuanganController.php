<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $ruangans = Ruangan::when($search, function($query, $search) {
                return $query->where('nama_ruangan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kasubag.ruangan.index', compact('ruangans', 'search'));
    }
}
