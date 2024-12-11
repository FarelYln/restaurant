<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Daftar menu
        $menus = [
            [
                'image' => 'nasi_goreng.jpg',
                'nama_menu' => 'Nasi Goreng',
                'harga' => 25000,
                'description' => 'Nasi goreng dengan campuran telur, ayam, dan bumbu khas Indonesia.',
                'categories' => [1] // Makanan
            ],
            [
                'image' => 'es_teh.jpg',
                'nama_menu' => 'Es Teh Manis',
                'harga' => 8000,
                'description' => 'Teh manis dingin yang menyegarkan.',
                'categories' => [2] // Minuman
            ],
            [
                'image' => 'brownies.jpg',
                'nama_menu' => 'Brownies Coklat',
                'harga' => 20000,
                'description' => 'Brownies coklat lembut dengan taburan kacang almond.',
                'categories' => [3, 4] // Dessert dan Roti
            ],
            [
                'image' => 'keripik_singkong.jpg',
                'nama_menu' => 'Keripik Singkong',
                'harga' => 15000,
                'description' => 'Keripik singkong gurih dengan rasa original.',
                'categories' => [5] // Snack
            ],
        ];

        foreach ($menus as $menu) {
            // Tambahkan data ke tabel menus
            $menuId = DB::table('menus')->insertGetId([
                'image' => 'menu/' . $menu['image'], // Path gambar
                'nama_menu' => $menu['nama_menu'],
                'harga' => $menu['harga'],
                'description' => $menu['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tambahkan data ke pivot table
            foreach ($menu['categories'] as $categoryId) {
                DB::table('category_menu')->insert([
                    'menu_id' => $menuId,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
