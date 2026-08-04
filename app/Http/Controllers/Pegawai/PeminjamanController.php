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
            ->groupBy('batch_id');

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
            ->addSelect(['*', 'total_barang' => Peminjaman::selectRaw('COUNT(*)')->from('peminjaman as p_sub')->whereColumn('p_sub.batch_id', 'peminjaman.batch_id')
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pegawai.peminjaman.index', compact('peminjamans', 'search', 'status'));
    }

    public function create(Request $request)
    {
        $selectedAset = $request->query('aset_id');
        $templateAset = null;
        $maxStok = 0;

        if ($selectedAset) {
            $templateAset = AsetBmn::find($selectedAset);
            if ($templateAset) {
                $maxStok = AsetBmn::where('kode_barang', $templateAset->kode_barang)
                                  ->where('nama_barang', $templateAset->nama_barang)
                                  ->where('merk', $templateAset->merk)
                                  ->where('tipe', $templateAset->tipe)
                                  ->where('nama', $templateAset->nama)
                                  ->where('status', 'tersedia')
                                  ->count();
            }
        }

        // Jika tidak ada parameter aset_id atau barangnya tidak valid/habis, redirect kembali ke katalog
        if (!$templateAset || $maxStok === 0) {
            return redirect()->route('pegawai.katalog_aset.index')->with('error', 'Aset tidak ditemukan atau stok tidak tersedia.');
        }

        return view('pegawai.peminjaman.create', compact('templateAset', 'maxStok'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_aset_id' => 'required|exists:aset_bmn,id',
            'jumlah' => 'required|integer|min:1',
            'keperluan' => 'required|string',
            'estimasi_waktu_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:estimasi_waktu_pinjam',
        ]);

        $templateAset = AsetBmn::findOrFail($request->template_aset_id);
        
        // Cari aset yang available sesuai template (kode, nama, merk, tipe, nama alias)
        $availableAsets = AsetBmn::where('kode_barang', $templateAset->kode_barang)
            ->where('nama_barang', $templateAset->nama_barang)
            ->where('merk', $templateAset->merk)
            ->where('tipe', $templateAset->tipe)
            ->where('nama', $templateAset->nama)
            ->where('status', 'tersedia')
            ->limit($request->jumlah)
            ->get();

        if ($availableAsets->count() < $request->jumlah) {
            return redirect()->back()->with('error', 'Gagal meminjam: Stok aset tidak mencukupi (Tersedia: ' . $availableAsets->count() . ').');
        }

        $peminjamanIds = [];
        $batchId = (string) Str::uuid();

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

            // Update status aset agar tidak bisa dipinjam orang lain
            $aset->update(['status' => 'menunggu_persetujuan']);
            $peminjamanIds[] = $peminjaman->id;
        }

        // Mengirim notifikasi WhatsApp (kirim 1 kali saja untuk mengabari ada peminjaman masuk)
        $usersToNotify = User::whereIn('role', ['kasubag_tu', 'operator'])
            ->whereNotNull('no_wa')
            ->where('no_wa', '!=', '')
            ->get();

        $namaPegawai = auth()->user()->name;
        $namaAset = $templateAset->nama_barang . ' (' . $request->jumlah . ' buah)';
        $pesan = "Halo, terdapat pengajuan peminjaman baru dari pegawai {$namaPegawai}. Aset yang dipinjam adalah {$namaAset}. Mohon untuk segera diproses di sistem SIM BMN.";

        $waService = app(\App\Services\WhatsappService::class);

        foreach ($usersToNotify as $user) {
            if ($user->no_wa) {
                // Untuk link notifikasi, kita bisa mengarah ke peminjaman pertama dari batch tersebut
                $waService->kirimPesan($user->no_wa, $pesan, $user->id, 'peminjaman', $peminjamanIds[0] ?? null);
            }
        }

        return redirect()->route('pegawai.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman ' . $request->jumlah . ' aset berhasil dikirim dan sedang menunggu persetujuan.');
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
