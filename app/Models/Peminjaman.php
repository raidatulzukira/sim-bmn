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
        'aset_id', 'user_id', 'keperluan', 'estimasi_waktu_pinjam',
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
}
