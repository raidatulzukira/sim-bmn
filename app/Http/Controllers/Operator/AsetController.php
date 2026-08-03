<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\AsetBmn;
use App\Models\Ruangan;
use App\Http\Requests\StoreAsetRequest;
use App\Http\Requests\UpdateAsetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AsetBmnImport;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis_bmn = $request->input('jenis_bmn');
        $status = $request->input('status');

        $asets = AsetBmn::with('ruangan')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('kode_barang', 'like', "%{$search}%")
                      ->orWhere('nama_barang', 'like', "%{$search}%")
                      ->orWhere('nup', 'like', "%{$search}%");
                });
            })
            ->when($jenis_bmn, function ($query, $jenis_bmn) {
                return $query->where('jenis_bmn', 'like', "%{$jenis_bmn}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('tanggal_perolehan', 'desc')
            ->orderBy('kode_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('operator.aset.index', compact('asets', 'search', 'jenis_bmn', 'status'));
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

        return view('operator.aset.rekap', compact('asets', 'search', 'kategori'));
    }

    public function create()
    {
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        return view('operator.aset.create', compact('ruangans'));
    }

    public function store(StoreAsetRequest $request)
    {
        $validated = $request->validated();

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

        $aset->delete();

        return redirect()->route('operator.aset.index')
            ->with('success', 'Data Aset berhasil dihapus.');
    }

    public function importForm()
    {
        return view('operator.aset.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120' // 5MB Max
        ]);

        try {
            Excel::import(new AsetBmnImport, $request->file('file_excel'));

            return redirect()->route('operator.aset.index')
                ->with('success', 'Data Aset BMN berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan validasi: <br>' . implode('<br>', $messages));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat impor data: ' . $e->getMessage());
        }
    }
}
