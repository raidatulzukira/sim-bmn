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
    public function kirimPesan(string $noWa, string $pesan, ?int $userId, string $referensiTipe, int $referensiId): bool
    {
        // 1. Simpan ke file log laravel
        Log::info("WA_GATEWAY: Mengirim ke $noWa", [
            'pesan' => $pesan,
            'user_id' => $userId,
            'referensi_tipe' => $referensiTipe,
            'referensi_id' => $referensiId
        ]);

        $statusKirim = 'gagal';

        // Jika nomor tujuan BUKAN log internal, maka kirim via WAHA
        if ($noWa !== 'internal_log') {
            // Format nomor WA: pastikan berawalan 62 dan hanya angka
            $noWaFormatted = preg_replace('/[^0-9]/', '', $noWa);
            if (str_starts_with($noWaFormatted, '0')) {
                $noWaFormatted = '62' . substr($noWaFormatted, 1);
            }

            try {
                // Konfigurasi dari .env
                $baseUrl = env('WAHA_BASE_URL', 'http://localhost:3000');
                $apiKey = env('WAHA_API_KEY', '');
                $sessionName = env('WAHA_SESSION', 'sim-bmn');

                // Menembak API WAHA Gateway dengan Autentikasi
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Accept' => 'application/json',
                    'X-Api-Key' => $apiKey,
                    'Authorization' => 'Bearer ' . $apiKey
                ])->post($baseUrl . '/api/sendText', [
                    'chatId' => $noWaFormatted . '@c.us',
                    'text' => $pesan,
                    'session' => $sessionName
                ]);
                
                if ($response->successful()) {
                    $statusKirim = 'terkirim';
                    Log::info("WAHA_GATEWAY: Pesan sukses dikirim ke $noWaFormatted");
                } else {
                    Log::error("WAHA_GATEWAY_ERROR: Gagal kirim. Response: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("WAHA_GATEWAY_EXCEPTION: Tidak dapat menghubungi server WAHA. Pastikan server WAHA menyala. Error: " . $e->getMessage());
            }
        } else {
            // Log internal (untuk riwayat dalam aplikasi saja tanpa dikirim ke WA)
            $statusKirim = 'terkirim';
        }

        // 2. Simpan ke database sebagai riwayat log
        NotifikasiLog::create([
            'user_id' => $userId,
            'referensi_tipe' => $referensiTipe,
            'referensi_id' => $referensiId,
            'pesan' => $pesan,
            'status_kirim' => $statusKirim,
        ]);

        return $statusKirim === 'terkirim';
    }
}
