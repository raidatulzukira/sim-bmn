<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\AsetBmn;

class PemeliharaanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'aset_id' => AsetBmn::inRandomOrder()->first()->id ?? 1,
            'jenis' => $this->faker->randomElement(['rutin', 'situasional']),
            'dilaporkan_oleh' => User::inRandomOrder()->first()->id ?? 1,
            'deskripsi_kerusakan' => $this->faker->sentence(),
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ];
    }
}
