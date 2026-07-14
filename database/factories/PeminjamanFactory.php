<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\AsetBmn;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'aset_id' => AsetBmn::inRandomOrder()->first()->id ?? 1,
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'keperluan' => $this->faker->sentence(),
            'estimasi_waktu_pinjam' => $this->faker->dateTimeBetween('now', '+1 week'),
            'tanggal_pinjam' => clone $this->faker->dateTimeBetween('-1 week', 'now'),
            'tanggal_kembali_rencana' => clone $this->faker->dateTimeBetween('now', '+2 weeks'),
            'status' => 'pending',
        ];
    }
}
