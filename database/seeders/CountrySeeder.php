<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Canada', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'India', 'created_at' => now(), 'updated_at' => now()],
        ];

        Country::insert($countries);
    }
}
