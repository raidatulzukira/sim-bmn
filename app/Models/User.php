<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'no_wa',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    public function persetujuanPeminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'approved_by');
    }

    public function laporanPemeliharaan(): HasMany
    {
        return $this->hasMany(Pemeliharaan::class, 'dilaporkan_oleh');
    }

    public function persetujuanPemeliharaan(): HasMany
    {
        return $this->hasMany(Pemeliharaan::class, 'approved_by');
    }

    public function notifikasiLog(): HasMany
    {
        return $this->hasMany(NotifikasiLog::class);
    }
}
