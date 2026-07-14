<?php

namespace App\Services;

use App\Models\User;
use App\Models\NotifikasiLog;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    /**
     * Kirim notifikasi pengajuan peminjaman baru ke Kasubag TU dan Operator
     */
    public static function sendPeminjamanBaru($peminjaman)
    {
        // Ambil data user yang memiliki role kasubag_tu dan operator
        $recipients = User::whereIn('role', ['kasubag_tu', 'operator'])->get();
        
        $pegawaiName = $peminjaman->user->name;
        $asetName = $peminjaman->asetBmn->nama_barang;
        $tglPinjam = $peminjaman->estimasi_waktu_pinjam->format('d M Y');
        
        $pesan = "Halo, terdapat pengajuan peminjaman baru.\n\n"
               . "Pegawai: {$pegawaiName}\n"
               . "Aset: {$asetName}\n"
               . "Tgl Pinjam: {$tglPinjam}\n\n"
               . "Mohon segera diperiksa melalui sistem SIM-BMN.";

        foreach ($recipients as $recipient) {
            // Log ke database
            NotifikasiLog::create([
                'user_id' => $recipient->id,
                'referensi_tipe' => 'peminjaman',
                'referensi_id' => $peminjaman->id,
                'pesan' => $pesan,
                'status_kirim' => 'pending' // Nanti diubah saat worker docker WA API berjalan
            ]);

            // Untuk sementara, log ke file laravel.log
            Log::info("WA Notification (Dummy) to {$recipient->name} ({$recipient->no_wa}):\n{$pesan}");
        }
    }
}
