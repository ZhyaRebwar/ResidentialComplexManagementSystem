<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Building;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartment = Building::all()->each(function ($building) {
            Apartment::factory()
                ->count(4)
                ->state(
                    ['building_id' => $building->id]
                )
                ->create();
        });
    }
}
