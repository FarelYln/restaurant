<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example categories to seed
        $categories = [
            ['nama_kategori' => 'Makanan'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Desert'],
            ['nama_kategori' => 'Roti'],
            ['nama_kategori' => 'Snack'],
        ];

        // Insert categories into the database
        DB::table('categories')->insert($categories);
    }
}