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

        $waService = new \App\Services\WhatsappService();

        foreach ($kasubags as $kasubag) {
            $phone = $kasubag->no_wa;
            
            if ($phone) {
                $waService->kirimPesan($phone, $pesan, $kasubag->id, 'pemeliharaan', $this->pemeliharaan_id);
            }
        }
    }
}
