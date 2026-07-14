<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Http\Requests\StoreRuanganRequest;
use App\Http\Requests\UpdateRuanganRequest;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $ruangans = Ruangan::withCount('asetBmn')
            ->when($search, function ($query, $search) {
                return $query->where('nama_ruangan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('operator.ruangan.index', compact('ruangans', 'search'));
    }

    public function create()
    {
        return view('operator.ruangan.create');
    }

    public function store(StoreRuanganRequest $request)
    {
        Ruangan::create($request->validated());

        return redirect()->route('operator.ruangan.index')
            ->with('success', 'Data Ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('operator.ruangan.edit', compact('ruangan'));
    }

    public function update(UpdateRuanganRequest $request, Ruangan $ruangan)
    {
        $ruangan->update($request->validated());

        return redirect()->route('operator.ruangan.index')
            ->with('success', 'Data Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        if ($ruangan->asetBmn()->exists()) {
            return redirect()->route('operator.ruangan.index')
                ->with('error', 'Ruangan tidak dapat dihapus karena masih berisi aset. Pindahkan aset terlebih dahulu.');
        }

        $ruangan->delete();

        return redirect()->route('operator.ruangan.index')
            ->with('success', 'Data Ruangan berhasil dihapus.');
    }
}
