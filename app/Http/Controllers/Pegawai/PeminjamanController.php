<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\AsetBmn;
use App\Models\User;
use App\Http\Requests\Pegawai\StorePeminjamanRequest;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $batchQuery = Peminjaman::select(DB::raw('MAX(id) as max_id'))
            ->where('user_id', auth()->id())
            ->groupBy('batch_id', 'status');

        $peminjamans = Peminjaman::with('asetBmn')
            ->whereIn('id', $batchQuery)
            ->when($search, function($query, $search) {
                return $query->whereHas('asetBmn', function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('kode_barang', 'like', "%{$search}%");
                })->orWhere('keperluan', 'like', "%{$search}%");
            })
            ->when($status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->addSelect(['*', 'total_barang' => Peminjaman::selectRaw('COUNT(*)')->from('peminjaman as p_sub')
                ->whereColumn('p_sub.batch_id', 'peminjaman.batch_id')
                ->whereColumn('p_sub.status', 'peminjaman.status')
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pegawai.peminjaman.index', compact('peminjamans', 'search', 'status'));
    }

    public function create(Request $request)
    {
        $keranjangIds = $request->input('keranjang_ids');

        if (!$keranjangIds || !is_array($keranjangIds) || count($keranjangIds) === 0) {
            return redirect()->route('pegawai.keranjang.index')->with('error', 'Pilih minimal satu aset dari keranjang untuk dipinjam.');
        }

        $keranjangItems = \App\Models\KeranjangPeminjaman::with('asetBmn')->where('user_id', auth()->id())->whereIn('id', $keranjangIds)->get();

        if ($keranjangItems->isEmpty()) {
            return redirect()->route('pegawai.keranjang.index')->with('error', 'Item keranjang tidak ditemukan.');
        }

        // Validate stock for all items
        foreach ($keranjangItems as $item) {
            $stokTersedia = AsetBmn::where('kode_barang', $item->asetBmn->kode_barang)
                ->where('nama_barang', $item->asetBmn->nama_barang)
                ->where('merk', $item->asetBmn->merk)
                ->where('tipe', $item->asetBmn->tipe)
                ->where('nama', $item->asetBmn->nama)
                ->where('status', 'tersedia')
                ->count();
                
            if ($item->jumlah > $stokTersedia) {
                return redirect()->route('pegawai.keranjang.index')->with('error', 'Stok untuk ' . $item->asetBmn->nama_barang . ' tidak mencukupi (Tersedia: ' . $stokTersedia . ', Diminta: ' . $item->jumlah . ').');
            }
        }

        return view('pegawai.peminjaman.create', compact('keranjangItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keranjang_ids' => 'required|array',
            'keranjang_ids.*' => 'exists:keranjang_peminjaman,id',
            'keperluan' => 'required|string',
            'estimasi_waktu_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:estimasi_waktu_pinjam',
        ], [
            'tanggal_kembali_rencana.after_or_equal' => 'Tanggal kembali harus sama dengan atau lebih akhir dari tanggal pinjam.',
            'keranjang_ids.required' => 'Pilih minimal satu aset dari keranjang.'
        ]);

        $keranjangItems = \App\Models\KeranjangPeminjaman::with('asetBmn')
            ->where('user_id', auth()->id())
            ->whereIn('id', $request->keranjang_ids)
            ->get();

        if ($keranjangItems->isEmpty()) {
            return redirect()->route('pegawai.keranjang.index')->with('error', 'Item keranjang tidak ditemukan.');
        }

        $peminjamanIds = [];
        $batchId = (string) Str::uuid();
        $totalAsetDiminta = 0;
        $namaAsetArray = [];

        DB::beginTransaction();
        try {
            foreach ($keranjangItems as $item) {
                $templateAset = $item->asetBmn;
                
                // Cari aset yang available
                $availableAsets = AsetBmn::where('kode_barang', $templateAset->kode_barang)
                    ->where('nama_barang', $templateAset->nama_barang)
                    ->where('merk', $templateAset->merk)
                    ->where('tipe', $templateAset->tipe)
                    ->where('nama', $templateAset->nama)
                    ->where('status', 'tersedia')
                    ->lockForUpdate() // Lock table to prevent race conditions
                    ->limit($item->jumlah)
                    ->get();

                if ($availableAsets->count() < $item->jumlah) {
                    DB::rollBack();
                    return redirect()->route('pegawai.keranjang.index')->with('error', 'Gagal meminjam: Stok ' . $templateAset->nama_barang . ' tidak mencukupi (Tersedia: ' . $availableAsets->count() . ').');
                }

                $totalAsetDiminta += $item->jumlah;
                $namaAsetArray[] = $templateAset->nama_barang . ' (' . $item->jumlah . ')';

                foreach ($availableAsets as $aset) {
                    $peminjaman = Peminjaman::create([
                        'batch_id' => $batchId,
                        'aset_id' => $aset->id,
                        'user_id' => auth()->id(),
                        'keperluan' => $request->keperluan,
                        'estimasi_waktu_pinjam' => $request->estimasi_waktu_pinjam,
                        'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                        'status' => 'pending',
                    ]);

                    $aset->update(['status' => 'menunggu_persetujuan']);
                    $peminjamanIds[] = $peminjaman->id;
                }
                
                // Hapus dari keranjang setelah diproses
                $item->delete();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }

        // Mengirim notifikasi WhatsApp
        $usersToNotify = User::whereIn('role', ['kasubag_tu', 'operator'])
            ->whereNotNull('no_wa')
            ->where('no_wa', '!=', '')
            ->get();

        $namaPegawai = auth()->user()->name;
        $namaAsetSummary = implode(', ', $namaAsetArray);
        $pesan = "Halo, terdapat pengajuan peminjaman baru dari pegawai {$namaPegawai}. Aset yang dipinjam adalah: {$namaAsetSummary}. Mohon untuk segera diproses di sistem SIM BMN.";

        $waService = app(\App\Services\WhatsappService::class);

        foreach ($usersToNotify as $user) {
            if ($user->no_wa) {
                $waService->kirimPesan($user->no_wa, $pesan, $user->id, 'peminjaman', $peminjamanIds[0] ?? null);
            }
        }

        return redirect()->route('pegawai.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman ' . $totalAsetDiminta . ' aset berhasil dikirim dan sedang menunggu persetujuan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        $batch = Peminjaman::with(['asetBmn.ruangan', 'approver'])->where('batch_id', $peminjaman->batch_id)->get();
        $peminjaman->load(['asetBmn.ruangan', 'approver']);
        
        return view('pegawai.peminjaman.show', compact('peminjaman', 'batch'));
    }
}
