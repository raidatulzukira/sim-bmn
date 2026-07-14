<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    protected $fillable = ['nama_ruangan', 'keterangan'];

    public function asetBmn(): HasMany
    {
        return $this->hasMany(AsetBmn::class);
    }
}
