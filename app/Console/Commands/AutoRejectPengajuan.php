<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use App\Models\Pemeliharaan;
use App\Models\AsetBmn;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoRejectPengajuan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-reject-pengajuan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis menolak pengajuan peminjaman dan pemeliharaan yang telah habis waktu validasinya oleh Kasubag.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $this->info("Memulai pengecekan auto-reject pengajuan pada {$now}");
        
        DB::beginTransaction();
        try {
            // 1. Peminjaman
            // Tolak jika status 'pending' dan waktu saat ini >= H-1 jam dari tanggal_kembali_rencana
            // Artinya: tanggal_kembali_rencana <= now() + 1 jam
            $peminjamans = Peminjaman::where('status', 'pending')
                ->where('tanggal_kembali_rencana', '<=', $now->copy()->addHour())
                ->get();

            $peminjamanCount = 0;
            foreach ($peminjamans as $peminjaman) {
                $peminjaman->update([
                    'status' => 'ditolak',
                    'catatan_penolakan' => 'Waktu pengajuan/validasi oleh Kasubag telah habis.',
                ]);

                if ($peminjaman->aset_id) {
                    AsetBmn::where('id', $peminjaman->aset_id)->update(['status' => 'tersedia']);
                }
                $peminjamanCount++;
            }
            $this->info("- Berhasil menolak {$peminjamanCount} pengajuan peminjaman.");

            // 2. Pemeliharaan Rutin
            // Tolak jika status 'pending', jenis 'rutin', dan waktu saat ini >= H-1 jam dari jadwal_servis_berikutnya
            $pemeliharaanRutins = Pemeliharaan::with('asetBmn')
                ->where('status', 'pending')
                ->where('jenis', 'rutin')
                ->get();
                
            $rutinCount = 0;
            foreach ($pemeliharaanRutins as $pr) {
                $aset = $pr->asetBmn;
                if ($aset) {
                    $jadwalBerikutnya = $aset->jadwal_servis_berikutnya;
                    if ($jadwalBerikutnya && $now->copy()->addHour()->greaterThanOrEqualTo($jadwalBerikutnya)) {
                        $pr->update([
                            'status' => 'ditolak',
                            'catatan_validasi' => 'Waktu pengajuan/validasi oleh Kasubag telah habis.',
                        ]);
                        AsetBmn::where('id', $pr->aset_id)->update(['status' => 'tersedia']);
                        $rutinCount++;
                    }
                }
            }
            $this->info("- Berhasil menolak {$rutinCount} pengajuan pemeliharaan rutin.");

            // 3. Pemeliharaan Situasional
            // Tolak jika status 'pending', jenis 'situasional', aset_id tidak null, 
            // dan sudah > 3 hari sejak aset ditentukan (dihitung dari updated_at)
            $pemeliharaanSits = Pemeliharaan::where('status', 'pending')
                ->where('jenis', 'situasional')
                ->whereNotNull('aset_id')
                ->where('updated_at', '<=', $now->copy()->subDays(3))
                ->get();

            $sitCount = 0;
            foreach ($pemeliharaanSits as $ps) {
                $ps->update([
                    'status' => 'ditolak',
                    'catatan_validasi' => 'Waktu pengajuan/validasi oleh Kasubag telah habis.',
                ]);
                AsetBmn::where('id', $ps->aset_id)->update(['status' => 'tersedia']);
                $sitCount++;
            }
            $this->info("- Berhasil menolak {$sitCount} pengajuan pemeliharaan situasional.");

            DB::commit();
            Log::info("AutoRejectPengajuan selesai dijalankan. PMJ: {$peminjamanCount}, Rutin: {$rutinCount}, Situasional: {$sitCount}");
            $this->info("Proses selesai.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error pada AutoRejectPengajuan: " . $e->getMessage());
            $this->error("Terjadi kesalahan: " . $e->getMessage());
        }
    }
}
