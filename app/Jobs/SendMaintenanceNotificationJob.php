<?php

namespace App\Jobs;

use App\Models\Pemeliharaan;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendMaintenanceNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $pemeliharaan_id;

    /**
     * Create a new job instance.
     */
    public function __construct($pemeliharaan_id)
    {
        $this->pemeliharaan_id = $pemeliharaan_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pemeliharaan = Pemeliharaan::with('asetBmn')->find($this->pemeliharaan_id);
        
        if (!$pemeliharaan) {
            return;
        }

        $kasubags = User::where('role', 'kasubag_tu')->get();
        $namaAset = $pemeliharaan->asetBmn->nama_barang ?? 'Tidak diketahui';

        $pesan = "Halo Bapak/Ibu Kasubag TU, terdapat pengajuan pemeliharaan/servis baru untuk aset {$namaAset}. Mohon untuk segera divalidasi melalui sistem.";

        $baseUrl = env('WAHA_BASE_URL', 'http://localhost:3000');
        $apiKey = env('WAHA_API_KEY', '');
        $wahaSession = env('WAHA_SESSION', 'default'); 

        foreach ($kasubags as $kasubag) {
            $phone = $kasubag->no_wa;
            
            if ($phone) {
                try {
                    // Format nomor untuk WAHA: ganti awalan 0 menjadi 62, lalu tambahkan @c.us
                    if (str_starts_with($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    }
                    
                    if (!str_ends_with($phone, '@c.us')) {
                        $phone .= '@c.us';
                    }

                    $response = Http::timeout(5)
                        ->withHeaders([
                            'X-Api-Key' => $apiKey,
                            'Accept' => 'application/json',
                        ])
                        ->post($baseUrl . '/api/sendText', [
                            'chatId' => $phone,
                            'text' => $pesan,
                            'session' => $wahaSession
                        ]);

                    if ($response->failed()) {
                        Log::error("WAHA Gateway Error (Maintenance Notification to {$phone}): " . $response->body());
                    }
                } catch (\Exception $e) {
                    Log::error("WAHA Gateway Exception (Maintenance Notification to {$phone}): " . $e->getMessage());
                }
            }
        }
    }
}
