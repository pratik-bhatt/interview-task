<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Los Angeles', 'state_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'San Francisco', 'state_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Houston', 'state_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Toronto', 'state_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mumbai', 'state_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Surat', 'state_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ahmedabad', 'state_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ];

        City::insert($cities);
    }
}
