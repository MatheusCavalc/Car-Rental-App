<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Car;
use App\Models\Location;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $location1 = Location::create([
            'name' => 'Fortaleza Aeroporto',
            'address' => 'Rua Aeroporto'
        ]);

        $location2 = Location::create([
            'name' => 'Fortaleza Centro',
            'address' => 'Rua Centro'
        ]);

        $car1 = Car::create([
            'model' => 'Onix',
            'brand' => 'Chevrolet',
            'year' => '2021',
            'daily_price' => 100.00,
            'location_id' => 1
        ]);
    }
}
