<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeliharaan extends Model
{
    use HasFactory;

    protected $table = 'pemeliharaan';
    protected $fillable = [
        'aset_id', 'jenis', 'dilaporkan_oleh', 'deskripsi_kerusakan',
        'status', 'catatan_validasi', 'approved_by', 'nota_teknisi',
        'tanggal_pengajuan', 'tanggal_selesai'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function asetBmn(): BelongsTo
    {
        return $this->belongsTo(AsetBmn::class, 'aset_id');
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dilaporkan_oleh');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
