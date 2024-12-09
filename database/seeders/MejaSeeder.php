<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    public function run()
    {
        // Membuat 25 entri meja
        for ($i = 1; $i <= 25; $i++) {
            Meja::create([
                'nomor_meja' => $i,
                'kapasitas' => rand(2, 10), // Kapasitas acak antara 2 hingga 10
                'status' => 'tersedia', // Semua status diatur menjadi 'tersedia'
                'location_id' => rand(1, 4), // location_id acak antara 1 hingga 4
            ]);
        }
    }
}