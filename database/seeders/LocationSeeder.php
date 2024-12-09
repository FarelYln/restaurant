<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        DB::table('locations')->insert([
            ['name' => 'indoor', 'floor' => 1],
            ['name' => 'outdoor', 'floor' => 1],
            ['name' => 'indoor', 'floor' => 2],
        ]);
    }
}