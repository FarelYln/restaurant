<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // Default password
            'role' => 'admin', // Role admin
        ]);

        // Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'), // Default password
            'role' => 'user', // Role user
        ]);

        User::create([
            'name' => 'Asep Samsudin',
            'email' => 'asepsamsudin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Cici Anggraini',
            'email' => 'cici.anggraini@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Dedi Prasetyo',
            'email' => 'dedi.prasetyo@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Erniwati',
            'email' => 'erniwati@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Fajar Setiawan',
            'email' => 'fajar.setiawan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Gina Sari',
            'email' => 'gina.sari@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Haris Gunawan',
            'email' => 'haris.gunawan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Indah Kusuma',
            'email' => 'indah.kusuma@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Joko Widodo',
            'email' => 'joko.widodo@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Kartika Dewi',
            'email' => 'kartika.dewi@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Lina Maharani',
            'email' => 'lina.maharani@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Mikael Rayhan',
            'email' => 'mikael.rayhan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Nina Apriani',
            'email' => 'nina.apriani@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Omar Faruk',
            'email' => 'omar.faruk@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Putri Amalia',
            'email' => 'putri.amalia@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Qori Syahira',
            'email' => 'qori.syahira@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Rendi Kurniawan',
            'email' => 'rendi.kurniawan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        
        User::create([
            'name' => 'Toni Priyanto',
            'email' => 'toni.priyanto@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
