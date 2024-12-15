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
            [
                'image' => 'sate_ayam.jpg',
                'nama_menu' => 'Sate Ayam',
                'harga' => 30000,
                'description' => 'Sate ayam dengan bumbu kacang yang lezat.',
                'categories' => [1, 5] // Makanan, Snack
            ],
            [
                'image' => 'mie_goreng.jpg',
                'nama_menu' => 'Mie Goreng',
                'harga' => 18000,
                'description' => 'Mie goreng dengan sayuran, telur, dan bumbu pilihan.',
                'categories' => [1] // Makanan
            ],
            [
                'image' => 'kopi.jpg',
                'nama_menu' => 'Kopi Hitam',
                'harga' => 12000,
                'description' => 'Kopi hitam dengan rasa yang kuat.',
                'categories' => [2] // Minuman
            ],
            [
                'image' => 'pisang_goreng.jpg',
                'nama_menu' => 'Pisang Goreng',
                'harga' => 10000,
                'description' => 'Pisang goreng dengan balutan tepung renyah.',
                'categories' => [3] // Dessert
            ],
            [
                'image' => 'salad.jpg',
                'nama_menu' => 'Salad Sayur',
                'harga' => 15000,
                'description' => 'Salad segar dengan sayuran pilihan dan saus mayones.',
                'categories' => [1, 3] // Makanan, Dessert
            ],
            [
                'image' => 'jus_apel.jpg',
                'nama_menu' => 'Jus Apel',
                'harga' => 12000,
                'description' => 'Jus apel segar dengan rasa alami.',
                'categories' => [2] // Minuman
            ],
            [
                'image' => 'nasi_uduk.jpg',
                'nama_menu' => 'Nasi Uduk',
                'harga' => 22000,
                'description' => 'Nasi uduk dengan lauk pauk lengkap.',
                'categories' => [1] // Makanan
            ],
            [
                'image' => 'soto.jpg',
                'nama_menu' => 'Soto Ayam',
                'harga' => 25000,
                'description' => 'Soto ayam dengan kuah kaldu segar dan bumbu rempah.',
                'categories' => [1] // Makanan
            ],
            [
                'image' => 'es_krim.jpg',
                'nama_menu' => 'Es Krim Coklat',
                'harga' => 15000,
                'description' => 'Es krim coklat dengan topping kacang almond.',
                'categories' => [3] // Dessert
            ],
            [
                'image' => 'wedang_jahe.jpg',
                'nama_menu' => 'Wedang Jahe',
                'harga' => 10000,
                'description' => 'Minuman jahe hangat untuk menghangatkan badan.',
                'categories' => [2] // Minuman
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
