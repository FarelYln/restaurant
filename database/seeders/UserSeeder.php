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
    }
}
