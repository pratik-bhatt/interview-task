<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'California', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Texas', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ontario', 'country_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maharashtra', 'country_id' => 3,'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gujarat', 'country_id' => 3,'created_at' => now(), 'updated_at' => now()],
        ];

        State::insert($states);
    }
}
