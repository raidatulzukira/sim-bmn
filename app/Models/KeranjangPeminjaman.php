<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'keranjang_peminjaman';

    protected $fillable = [
        'user_id',
        'template_aset_id',
        'jumlah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asetBmn()
    {
        return $this->belongsTo(AsetBmn::class, 'template_aset_id');
    }
}
