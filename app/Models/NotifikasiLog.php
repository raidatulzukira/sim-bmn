<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotifikasiLog extends Model
{
    protected $table = 'notifikasi_log';
    protected $fillable = [
        'user_id', 'referensi_tipe', 'referensi_id', 'pesan', 'status_kirim'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
