<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Http\Requests\ApprovePeminjamanRequest;
use App\Http\Requests\RejectPeminjamanRequest;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersetujuanPeminjamanController extends Controller
{
    public function __construct(protected WhatsappService $waService)
    {
    }

    public function index(Request $request)
    {
        $tab = $request->input('tab', 'pending');

        $query = Peminjaman::with(['user', 'asetBmn']);

        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } else {
            $query->whereIn('status', ['disetujui', 'ditolak', 'dipinjam', 'dikembalikan']);
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('kasubag.peminjaman.index', compact('peminjamans', 'tab'));
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'asetBmn', 'approver']);
        return view('kasubag.peminjaman.show', compact('peminjaman'));
    }

    public function approve(ApprovePeminjamanRequest $request, Peminjaman $peminjaman)
    {
        try {
            DB::transaction(function () use ($peminjaman) {
                // Lock for update to prevent double submission
                $lockedPeminjaman = Peminjaman::where('id', $peminjaman->id)->lockForUpdate()->first();

                if ($lockedPeminjaman->status !== 'pending') {
                    throw new \Exception('Pengajuan ini sudah diproses sebelumnya.');
                }

                $lockedPeminjaman->update([
                    'status' => 'disetujui',
                    'approved_by' => auth()->id(),
                ]);
            });

            // Refresh model instance
            $peminjaman->refresh();
            $peminjaman->load(['asetBmn', 'user']);

            // Kirim WA
            $pesan = "Pengajuan peminjaman aset {$peminjaman->asetBmn->nama_aset} Anda telah DISETUJUI oleh Kasubag TU. Silakan temui Operator untuk serah terima barang.";
            if ($peminjaman->user->no_wa) {
                $this->waService->kirimPesan($peminjaman->user->no_wa, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            }

            return redirect()->route('kasubag.persetujuan.index')->with('success', 'Pengajuan berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(RejectPeminjamanRequest $request, Peminjaman $peminjaman)
    {
        try {
            DB::transaction(function () use ($request, $peminjaman) {
                $lockedPeminjaman = Peminjaman::where('id', $peminjaman->id)->lockForUpdate()->first();

                if ($lockedPeminjaman->status !== 'pending') {
                    throw new \Exception('Pengajuan ini sudah diproses sebelumnya.');
                }

                $lockedPeminjaman->update([
                    'status' => 'ditolak',
                    'approved_by' => auth()->id(),
                    'catatan_penolakan' => $request->validated('catatan_penolakan'),
                ]);
            });

            // Refresh model instance
            $peminjaman->refresh();
            $peminjaman->load(['asetBmn', 'user']);

            // Kirim WA
            $pesan = "Pengajuan peminjaman aset {$peminjaman->asetBmn->nama_aset} Anda telah DITOLAK. Alasan: {$peminjaman->catatan_penolakan}";
            if ($peminjaman->user->no_wa) {
                $this->waService->kirimPesan($peminjaman->user->no_wa, $pesan, $peminjaman->user_id, 'peminjaman', $peminjaman->id);
            }

            return redirect()->route('kasubag.persetujuan.index')->with('success', 'Pengajuan berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
