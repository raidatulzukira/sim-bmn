<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ruangan;

class AsetBmnFactory extends Factory
{
    public function definition(): array
    {
        return [
            'jenis_bmn' => $this->faker->randomElement(['Elektronik', 'Furnitur', 'Kendaraan']),
            'kode_barang' => 'BMN-' . $this->faker->unique()->numerify('#####'),
            'nup' => $this->faker->numerify('###'),
            'nama_barang' => $this->faker->randomElement(['Laptop Lenovo', 'Proyektor Epson', 'PC Desktop Dell', 'Printer HP', 'AC Daikin']),
            'merk' => $this->faker->company(),
            'tipe' => $this->faker->word(),
            'nama' => $this->faker->words(3, true),
            'tanggal_perolehan' => $this->faker->date(),
            'nilai_perolehan_pertama' => $this->faker->randomFloat(2, 1000000, 50000000),
            'ruangan_id' => Ruangan::inRandomOrder()->first()->id ?? 1,
            'status' => $this->faker->randomElement(['tersedia', 'dipinjam', 'servis']),
        ];
    }
}
