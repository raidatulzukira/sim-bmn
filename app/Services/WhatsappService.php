<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\NotifikasiLog;

class WhatsappService
{
    /**
     * Mengirim pesan WhatsApp.
     * Saat ini berupa dummy log. Nanti diisi API Gateway WA.
     */
    public function kirimPesan(string $noWa, string $pesan, int $userId, string $referensiTipe, int $referensiId): bool
    {
        // 1. Simpan ke file log laravel
        Log::info("WA_GATEWAY: Mengirim ke $noWa", [
            'pesan' => $pesan,
            'user_id' => $userId,
            'referensi_tipe' => $referensiTipe,
            'referensi_id' => $referensiId
        ]);

        // 2. Simpan ke database
        NotifikasiLog::create([
            'user_id' => $userId,
            'referensi_tipe' => $referensiTipe,
            'referensi_id' => $referensiId,
            'pesan' => $pesan,
            'status_kirim' => 'terkirim', // dummy sukses
        ]);

        return true;
    }
}
