<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\AsetBmn;
use App\Models\Peminjaman;
use App\Models\Pemeliharaan;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users
        $operator = User::create([
            'name' => 'Operator',
            'email' => 'operator@bdi.id',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'operator',
            'nip' => '198001012005011001',
            'no_wa' => '082173885172'
        ]);

        $kasubag = User::create([
            'name' => 'Kasubag TU',
            'email' => 'kasubag@bdi.id',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'kasubag_tu',
            'nip' => '198001012005012002',
            'no_wa' => '081213007587'
        ]);

        // $kasubag = User::factory()->create([
        //     'name' => 'Kasubag TU',
        //     'email' => 'kasubag@bdi.id',
        //     'password' => Hash::make('password'),
        //     'role' => 'kasubag_tu',
        //     'nip' => '197501012000011002',
        //     'no_wa' => '081234567891'
        // ]);

        // $pegawai1 = User::factory()->create([
        //     'name' => 'Pegawai Satu',
        //     'email' => 'pegawai1@bdi.id',
        //     'password' => Hash::make('password'),
        //     'role' => 'pegawai',
        //     'nip' => '199001012010011003',
        //     'no_wa' => '081234567892'
        // ]);

        // $pegawai2 = User::factory()->create([
        //     'name' => 'Pegawai Dua',
        //     'email' => 'pegawai2@bdi.id',
        //     'password' => Hash::make('password'),
        //     'role' => 'pegawai',
        //     'nip' => '199201012015011004',
        //     'no_wa' => '081234567893'
        // ]);

        // 2. Create Ruangan (Real data from SK PDF)
        $ruangans = [
            // 1. Ruang Kantor
            ['nama_ruangan' => 'Ruang Kantor', 'peruntukan' => 'Tempat Pekerjaan administrasi dan operasional pegawai', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 1'],
            ['nama_ruangan' => 'Ruang KA TU', 'peruntukan' => 'Tempat Pekerjaan administrasi dan operasional pegawai', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 1'],
            ['nama_ruangan' => 'R. Bendahara', 'peruntukan' => 'Tempat Pekerjaan administrasi dan operasional pegawai', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 1'],
            
            // 2. Garasi
            ['nama_ruangan' => 'Garasi', 'peruntukan' => 'Tempat Parkir kendaraan dinas/operasional', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 1'],
            
            // 3. Ruang Arsip
            ['nama_ruangan' => 'Ruang Arsip', 'peruntukan' => 'Tempat untuk menyimpan dokumen dan arsip', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 1'],
            ['nama_ruangan' => 'R. Arsip 02', 'peruntukan' => 'Tempat untuk menyimpan dokumen dan arsip', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 1'],
            ['nama_ruangan' => 'R. Gudang Arsip', 'peruntukan' => 'Tempat untuk menyimpan dokumen dan arsip', 'lokasi' => 'Gedung Asrama A', 'lantai' => 'Lantai 2'],

            // 4. Ruang Musholah
            ['nama_ruangan' => 'Ruang Musholah', 'peruntukan' => 'Tempat untuk kegiatan ibadah', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 1'],
            
            // 5. Ruang Server
            ['nama_ruangan' => 'Ruang Server', 'peruntukan' => 'Tempat untuk pengelolaan server dan jaringan', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 2'],
            
            // 6. Labor Komputer
            ['nama_ruangan' => 'Labor Komputer', 'peruntukan' => 'Tempat untuk praktik dan pelatihan komputer', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 2'],
            
            // 7. Ruang LSP
            ['nama_ruangan' => 'Ruang LSP', 'peruntukan' => 'Tempat untuk proses penertbitan sertifikasi profesi', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 2'],
            
            // 8. Ruang Sulam
            ['nama_ruangan' => 'Ruang Sulam', 'peruntukan' => 'Tempat untuk praktik sulaman', 'lokasi' => 'Gedung Kantor', 'lantai' => 'Lantai 2'],
            
            // 9. Lobi
            ['nama_ruangan' => 'R. Pelayanan & Lobi', 'peruntukan' => 'Tempat penghubung untuk memperoleh layanan yang diperlukan', 'lokasi' => 'Gedung Utama', 'lantai' => 'Lantai 1'],
            ['nama_ruangan' => 'Lobi Asrama A', 'peruntukan' => 'Tempat penghubung untuk memperoleh layanan yang diperlukan', 'lokasi' => 'Gedung Asrama A', 'lantai' => 'Lantai 1'],

            // 10. Ruang Rapat
            ['nama_ruangan' => 'Ruang Rapat', 'peruntukan' => 'Tempat untuk rapat pegawai dan koordinasi', 'lokasi' => 'Gedung Utama', 'lantai' => 'Lantai 1'],
            
            // 11. Ruang Teaching Factory
            ['nama_ruangan' => 'Teaching Factory', 'peruntukan' => 'Tempat untuk praktik produksi berbasis industri', 'lokasi' => 'Gedung Utama', 'lantai' => 'Lantai 1'],
            
            // 12. Ruang Custome made
            ['nama_ruangan' => 'Ruang Costume made', 'peruntukan' => 'Tempat untuk manjahit pakaian', 'lokasi' => 'Gedung Utama', 'lantai' => 'Lantai 2'],
            
            // 13. Kantin Peserta
            ['nama_ruangan' => 'Kantin Peserta', 'peruntukan' => 'Tempat untuk makan dan istirahat peserta', 'lokasi' => 'Gedung Pelatihan dan Kantin', 'lantai' => 'Lantai 1'],
            
            // 14. Aula Terbuka
            ['nama_ruangan' => 'Aula Terbuka', 'peruntukan' => 'Tempat untuk kegiatan umum berskala menengah', 'lokasi' => 'Gedung Pelatihan dan Kantin', 'lantai' => 'Lantai 2'],
            
            // 15. Ruang Jaga Satpam
            ['nama_ruangan' => 'Pos Satpam', 'peruntukan' => 'Tempat untuk pengawasan dan penjagaan keamanan', 'lokasi' => 'Pos Jaga Permanen', 'lantai' => 'Lantai 1'],
            
            // 16. Ruang Tenun
            ['nama_ruangan' => 'Ruang Tenun', 'peruntukan' => 'Tempat untuk praktik dan produksi tenun', 'lokasi' => 'Gedung Asrama C', 'lantai' => 'Lantai 2'],
            
            // 17. Aula Gedung B
            ['nama_ruangan' => 'Aula Gedung B', 'peruntukan' => 'Tempat untuk kegiatan pertemuan', 'lokasi' => 'Gedung Asrama B', 'lantai' => 'Lantai 2'],
            
            // 18. Kantin Pengajar/Instruktur
            ['nama_ruangan' => 'Kantin Pengajar/Instruktur', 'peruntukan' => 'Tempat untuk makan dan istirahat pengajar', 'lokasi' => 'Gedung Asrama A', 'lantai' => 'Lantai 1'],
            
            // 20. Ruang Inbis/Finishing
            ['nama_ruangan' => 'R. Inbis / Finishing', 'peruntukan' => 'Tempat untuk kegiatan inkubator bisnis dan finishing produk', 'lokasi' => 'Gedung Asrama A', 'lantai' => 'Lantai 2'],
            
            // 21. Ruang Bordir Highspeed
            ['nama_ruangan' => 'R. Bordir Highspeed', 'peruntukan' => 'Tempat untuk praktik bordir bertenaga mesin', 'lokasi' => 'Gedung Asrama A', 'lantai' => 'Lantai 2'],
            
            // 22. Ruang Brodir Manual
            ['nama_ruangan' => 'R. Bordir Manual', 'peruntukan' => 'Tempat untuk praktik bordir bertenaga manual', 'lokasi' => 'Gedung Asrama A', 'lantai' => 'Lantai 2'],
            
            // 23. Ruang Tamu
            ['nama_ruangan' => 'R. Tamu', 'peruntukan' => 'Tempat menerima tamu', 'lokasi' => 'Rumah Dinas', 'lantai' => 'Lantai 1'],
            
            // Additional non-numbered rooms from layout
            ['nama_ruangan' => 'R. Pimpinan', 'peruntukan' => 'Tempat Pekerjaan administrasi dan operasional pejabat', 'lokasi' => 'Gedung Utama', 'lantai' => 'Lantai 1'],
            ['nama_ruangan' => 'R. Tunggu Pelayanan', 'peruntukan' => 'Tempat menunggu pelayanan', 'lokasi' => 'Gedung Utama', 'lantai' => 'Lantai 1'],
            ['nama_ruangan' => 'R. Tunggu', 'peruntukan' => 'Tempat menunggu pelayanan', 'lokasi' => 'Gedung Utama', 'lantai' => 'Lantai 2'],
            ['nama_ruangan' => 'Dapur', 'peruntukan' => 'Tempat memasak', 'lokasi' => 'Rumah Dinas', 'lantai' => 'Lantai 1'],
        ];

        // 19. Kamar Asrama (46 Kamar generated using loop)
        for ($i = 1; $i <= 18; $i++) {
            $ruangans[] = ['nama_ruangan' => 'Kamar A' . $i, 'peruntukan' => 'Tempat untuk istirahat dan tempat tinggal untuk peserta diklat', 'lokasi' => 'Gedung Asrama A', 'lantai' => 'Lantai 1'];
        }
        for ($i = 1; $i <= 12; $i++) {
            $ruangans[] = ['nama_ruangan' => 'Asrama B ' . $i, 'peruntukan' => 'Tempat untuk istirahat dan tempat tinggal untuk peserta diklat', 'lokasi' => 'Gedung Asrama B', 'lantai' => 'Lantai 1'];
        }
        for ($i = 13; $i <= 18; $i++) {
            $ruangans[] = ['nama_ruangan' => 'Asrama B ' . $i, 'peruntukan' => 'Tempat untuk istirahat dan tempat tinggal untuk peserta diklat', 'lokasi' => 'Gedung Asrama B', 'lantai' => 'Lantai 2'];
        }
        for ($i = 1; $i <= 10; $i++) {
            $ruangans[] = ['nama_ruangan' => 'Asrama C' . $i, 'peruntukan' => 'Tempat untuk istirahat dan tempat tinggal untuk peserta diklat', 'lokasi' => 'Gedung Asrama C', 'lantai' => 'Lantai 1'];
        }

        // 24. Kamar rumah dinas (3 Kamar generated using loop)
        for ($i = 1; $i <= 3; $i++) {
            $ruangans[] = ['nama_ruangan' => 'Kamar ' . $i, 'peruntukan' => 'Tempat untuk istirahat pejabat yang menempati', 'lokasi' => 'Rumah Dinas', 'lantai' => 'Lantai 1'];
        }

        foreach ($ruangans as $ruangan) {
            Ruangan::create($ruangan);
        }

        // 3. Create Aset BMN using Factory
        // AsetBmn::factory()->count(15)->create();

        // 4. Create Peminjaman dummy data
        // $asetTersedia = AsetBmn::where('status', 'tersedia')->get();
        // if($asetTersedia->count() >= 2) {
        //     Peminjaman::factory()->create([
        //         'user_id' => $pegawai1->id,
        //         'aset_id' => $asetTersedia[0]->id,
        //         'status' => 'pending'
        //     ]);

        //     Peminjaman::factory()->create([
        //         'user_id' => $pegawai2->id,
        //         'aset_id' => $asetTersedia[1]->id,
        //         'status' => 'disetujui',
        //         'approved_by' => $kasubag->id
        //     ]);
        // }

        // 5. Create Pemeliharaan dummy data
        // $asetRusak = AsetBmn::inRandomOrder()->first();
        // if ($asetRusak) {
        //     Pemeliharaan::factory()->create([
        //         'aset_id' => $asetRusak->id,
        //         'jenis' => 'situasional',
        //         'dilaporkan_oleh' => $pegawai1->id,
        //         'status' => 'pending'
        //     ]);
        // }
    }
}
