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
        'jenis_bmn', 'kode_barang', 'nup', 'nama_barang', 'merk', 'tipe', 'nama', 'tanggal_perolehan', 'nilai_perolehan_pertama', 'foto', 'ruangan_id', 'status',
        'interval_servis_tahun', 'tanggal_servis_terakhir'
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'tanggal_servis_terakhir' => 'date',
    ];

    public function getJadwalServisBerikutnyaAttribute()
    {
        if ($this->interval_servis_tahun && $this->tanggal_servis_terakhir) {
            return $this->tanggal_servis_terakhir->copy()->addYears($this->interval_servis_tahun);
        }
        return null;
    }

    public function getIsServisWarningAttribute()
    {
        $next = $this->jadwal_servis_berikutnya;
        if ($next) {
            // Beri peringatan jika hari ini sudah melewati atau H-30 dari jadwal servis berikutnya
            return now()->copy()->addDays(30)->greaterThanOrEqualTo($next);
        }
        return false;
    }

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
