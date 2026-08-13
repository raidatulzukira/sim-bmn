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

        $waService = new \App\Services\WhatsappService();
        $totalUnit = Pemeliharaan::where('batch_id', $pemeliharaan->batch_id)->count();

        // 1. Jika aset_id belum ditentukan (laporan baru dari pegawai) -> Kirim WA ke Operator
        if (is_null($pemeliharaan->aset_id)) {
            $operators = User::where('role', 'operator')->get();
            $pesan = "Halo Bapak/Ibu Operator, terdapat pelaporan kerusakan (situasional) baru dari pegawai.\n"
                   . "No. Nota: {$pemeliharaan->batch_id}\n"
                   . "Mohon untuk segera meninjau laporan tersebut dan menentukan Aset BMN yang dimaksud melalui sistem.";
            
            foreach ($operators as $operator) {
                if ($operator->no_wa) {
                    $waService->kirimPesan($operator->no_wa, $pesan, $operator->id, 'pemeliharaan', $this->pemeliharaan_id);
                }
            }
            return;
        }

        // 2. Jika aset_id sudah ada (sudah ditentukan operator atau servis rutin) -> Kirim WA ke Kasubag TU
        $kasubags = User::where('role', 'kasubag_tu')->get();
        $namaAset = $pemeliharaan->asetBmn->nama_barang ?? 'Tidak diketahui';
        
        $pesan = "Halo Bapak/Ibu Kasubag TU, terdapat pengajuan pemeliharaan/servis baru.\n"
               . "No. Nota: {$pemeliharaan->batch_id}\n";
        if ($totalUnit > 1) {
            $pesan .= "Aset: {$totalUnit} unit {$namaAset}\n";
        } else {
            $pesan .= "Aset: {$namaAset}\n";
        }
        $pesan .= "Mohon untuk segera divalidasi melalui sistem.";

        foreach ($kasubags as $kasubag) {
            if ($kasubag->no_wa) {
                $waService->kirimPesan($kasubag->no_wa, $pesan, $kasubag->id, 'pemeliharaan', $this->pemeliharaan_id);
            }
        }
    }
}
