<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\House;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $house_facility_id = Facility::where('facility_type', 'house')->first()->id;

        $house = House::factory()
            ->count(3)
            ->state(
                ['facility_id' => $house_facility_id],
            )
            ->create();
    }
}
