<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsetBmn extends Model
{
    use HasFactory;

    protected $table = 'aset_bmn';
    protected $fillable = [
        'jenis_bmn', 'kode_barang', 'nup', 'nama_barang', 'merk', 'tipe', 'nama', 'tanggal_perolehan', 'nilai_perolehan_pertama', 'foto', 'ruangan_id', 'status'
    ];

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'aset_id');
    }

    public function pemeliharaan(): HasMany
    {
        return $this->hasMany(Pemeliharaan::class, 'aset_id');
    }
}
