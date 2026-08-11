<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\KeranjangPeminjaman;
use App\Models\AsetBmn;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = KeranjangPeminjaman::with('asetBmn')->where('user_id', auth()->id())->get();
        
        // Inject info max stok untuk tiap item
        foreach($keranjang as $item) {
            $item->stok_tersedia = AsetBmn::where('kode_barang', $item->asetBmn->kode_barang)
                ->where('nama_barang', $item->asetBmn->nama_barang)
                ->where('merk', $item->asetBmn->merk)
                ->where('tipe', $item->asetBmn->tipe)
                ->where('nama', $item->asetBmn->nama)
                ->where('status', 'tersedia')
                ->count();
        }

        return view('pegawai.keranjang.index', compact('keranjang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_aset_id' => 'required|exists:aset_bmn,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $templateAset = AsetBmn::findOrFail($request->template_aset_id);

        // Cek stok tersedia
        $stokTersedia = AsetBmn::where('kode_barang', $templateAset->kode_barang)
            ->where('nama_barang', $templateAset->nama_barang)
            ->where('merk', $templateAset->merk)
            ->where('tipe', $templateAset->tipe)
            ->where('nama', $templateAset->nama)
            ->where('status', 'tersedia')
            ->count();

        if ($request->jumlah > $stokTersedia) {
            return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia (' . $stokTersedia . ').');
        }

        // Cek apakah barang sudah ada di keranjang, jika ada tambahkan jumlahnya
        $existingCart = KeranjangPeminjaman::where('user_id', auth()->id())
            ->where('template_aset_id', $templateAset->id)
            ->first();

        if ($existingCart) {
            $newJumlah = $existingCart->jumlah + $request->jumlah;
            if ($newJumlah > $stokTersedia) {
                return redirect()->back()->with('error', 'Total jumlah di keranjang dan yang baru ditambahkan melebihi stok tersedia. Anda saat ini memiliki ' . $existingCart->jumlah . ' barang ini di keranjang.');
            }
            $existingCart->update(['jumlah' => $newJumlah]);
        } else {
            KeranjangPeminjaman::create([
                'user_id' => auth()->id(),
                'template_aset_id' => $templateAset->id,
                'jumlah' => $request->jumlah
            ]);
        }

        return redirect()->route('pegawai.keranjang.index')->with('success', 'Aset berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $keranjang = KeranjangPeminjaman::where('user_id', auth()->id())->findOrFail($id);
        $keranjang->delete();

        return redirect()->route('pegawai.keranjang.index')->with('success', 'Aset berhasil dihapus dari keranjang.');
    }
}
