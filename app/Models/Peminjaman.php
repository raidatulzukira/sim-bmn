<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $fillable = [
        'batch_id',
        'aset_id',
        'user_id',
        'keperluan', 'estimasi_waktu_pinjam',
        'tanggal_pinjam', 'tanggal_kembali_rencana', 'tanggal_kembali_aktual',
        'status', 'catatan_penolakan', 'foto_serah_terima', 'foto_pengembalian', 'approved_by'
    ];

    protected function casts(): array
    {
        return [
            'estimasi_waktu_pinjam' => 'datetime',
            'tanggal_pinjam' => 'datetime',
            'tanggal_kembali_rencana' => 'datetime',
            'tanggal_kembali_aktual' => 'datetime',
        ];
    }

    public function asetBmn(): BelongsTo
    {
        return $this->belongsTo(AsetBmn::class, 'aset_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getKeteranganTerlambatAttribute()
    {
        if (!$this->tanggal_kembali_rencana) return null;

        $rencana = $this->tanggal_kembali_rencana->copy()->startOfDay();

        if ($this->status === 'dikembalikan' && $this->tanggal_kembali_aktual) {
            $aktual = $this->tanggal_kembali_aktual->copy()->startOfDay();
            $terlambatHari = $rencana->diffInDays($aktual, false);
            if ($terlambatHari > 0) {
                return (int) $terlambatHari;
            }
        } elseif ($this->status === 'dipinjam') {
            $sekarang = now()->startOfDay();
            $terlambatHari = $rencana->diffInDays($sekarang, false);
            if ($terlambatHari > 0) {
                return (int) $terlambatHari;
            }
        }

        return null;
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu TU',
            'disetujui' => 'Disetujui',
            'dipinjam' => 'Sedang Dipinjam',
            'dikembalikan' => 'Selesai Dikembalikan',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status)
        };
    }
}
