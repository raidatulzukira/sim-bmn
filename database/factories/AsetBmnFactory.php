<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ruangan;

class AsetBmnFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_barang' => 'BMN-' . $this->faker->unique()->numerify('#####'),
            'nama_barang' => $this->faker->randomElement(['Laptop Lenovo', 'Proyektor Epson', 'PC Desktop Dell', 'Printer HP', 'AC Daikin']),
            'kategori' => $this->faker->randomElement(['Elektronik', 'Furnitur', 'Kendaraan']),
            'spesifikasi' => $this->faker->sentence(),
            'ruangan_id' => Ruangan::inRandomOrder()->first()->id ?? 1,
            'status' => $this->faker->randomElement(['tersedia', 'dipinjam', 'servis']),
        ];
    }
}
