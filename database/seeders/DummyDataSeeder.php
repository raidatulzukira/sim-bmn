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
        $operator = User::factory()->create([
            'name' => 'Operator System',
            'email' => 'operator@bdi.id',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'nip' => '198001012005011001',
            'no_wa' => '081234567890'
        ]);

        $kasubag = User::factory()->create([
            'name' => 'Kasubag TU',
            'email' => 'kasubag@bdi.id',
            'password' => Hash::make('password'),
            'role' => 'kasubag_tu',
            'nip' => '197501012000011002',
            'no_wa' => '081234567891'
        ]);

        $pegawai1 = User::factory()->create([
            'name' => 'Pegawai Satu',
            'email' => 'pegawai1@bdi.id',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'nip' => '199001012010011003',
            'no_wa' => '081234567892'
        ]);

        $pegawai2 = User::factory()->create([
            'name' => 'Pegawai Dua',
            'email' => 'pegawai2@bdi.id',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'nip' => '199201012015011004',
            'no_wa' => '081234567893'
        ]);

        // 2. Create Ruangan
        $ruangans = [
            ['nama_ruangan' => 'Ruang Server', 'keterangan' => 'Pusat Data BDI'],
            ['nama_ruangan' => 'Gudang A', 'keterangan' => 'Gudang Penyimpanan Barang Elektronik'],
            ['nama_ruangan' => 'Ruang Rapat', 'keterangan' => 'Ruang Rapat Utama'],
            ['nama_ruangan' => 'Lab Komputer', 'keterangan' => 'Laboratorium Praktik'],
        ];

        foreach ($ruangans as $ruangan) {
            Ruangan::create($ruangan);
        }

        // 3. Create Aset BMN using Factory
        AsetBmn::factory()->count(15)->create();

        // 4. Create Peminjaman dummy data
        $asetTersedia = AsetBmn::where('status', 'tersedia')->get();
        if($asetTersedia->count() >= 2) {
            Peminjaman::factory()->create([
                'user_id' => $pegawai1->id,
                'aset_id' => $asetTersedia[0]->id,
                'status' => 'pending'
            ]);

            Peminjaman::factory()->create([
                'user_id' => $pegawai2->id,
                'aset_id' => $asetTersedia[1]->id,
                'status' => 'disetujui',
                'approved_by' => $kasubag->id
            ]);
        }

        // 5. Create Pemeliharaan dummy data
        $asetRusak = AsetBmn::inRandomOrder()->first();
        if ($asetRusak) {
            Pemeliharaan::factory()->create([
                'aset_id' => $asetRusak->id,
                'jenis' => 'situasional',
                'dilaporkan_oleh' => $pegawai1->id,
                'status' => 'pending'
            ]);
        }
    }
}
