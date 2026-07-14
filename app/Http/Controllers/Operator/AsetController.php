<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\AsetBmn;
use App\Models\Ruangan;
use App\Http\Requests\StoreAsetRequest;
use App\Http\Requests\UpdateAsetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $status = $request->input('status');

        $asets = AsetBmn::with('ruangan')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('kode_aset', 'like', "%{$search}%")
                      ->orWhere('nama_aset', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('operator.aset.index', compact('asets', 'search', 'kategori', 'status'));
    }

    public function create()
    {
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        return view('operator.aset.create', compact('ruangans'));
    }

    public function store(StoreAsetRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('aset', 'public');
            $validated['foto'] = $path;
        }

        AsetBmn::create($validated);

        return redirect()->route('operator.aset.index')
            ->with('success', 'Data Aset berhasil ditambahkan.');
    }

    public function show(AsetBmn $aset)
    {
        $aset->load(['ruangan', 'peminjaman' => function($q) {
            $q->latest()->limit(5)->with('user');
        }, 'pemeliharaan' => function($q) {
            $q->latest()->limit(5)->with('pelapor');
        }]);

        return view('operator.aset.show', compact('aset'));
    }

    public function edit(AsetBmn $aset)
    {
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        return view('operator.aset.edit', compact('aset', 'ruangans'));
    }

    public function update(UpdateAsetRequest $request, AsetBmn $aset)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($aset->foto && Storage::disk('public')->exists($aset->foto)) {
                Storage::disk('public')->delete($aset->foto);
            }
            $path = $request->file('foto')->store('aset', 'public');
            $validated['foto'] = $path;
        }

        $aset->update($validated);

        return redirect()->route('operator.aset.index')
            ->with('success', 'Data Aset berhasil diperbarui.');
    }

    public function destroy(AsetBmn $aset)
    {
        if (in_array($aset->status, ['dipinjam', 'servis'])) {
            return redirect()->route('operator.aset.index')
                ->with('error', 'Aset tidak dapat dihapus karena masih berstatus ' . $aset->status . '.');
        }

        if ($aset->foto && Storage::disk('public')->exists($aset->foto)) {
            Storage::disk('public')->delete($aset->foto);
        }

        $aset->delete();

        return redirect()->route('operator.aset.index')
            ->with('success', 'Data Aset berhasil dihapus.');
    }
}
