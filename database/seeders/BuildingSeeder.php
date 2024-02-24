<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Facility;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $building_facility_id = Facility::where('facility_type', 'building')->first()->id;

        $building = Building::factory()
            ->count(3)
            ->state(
                ['facility_id' => $building_facility_id],
            )
            ->create();
    }
}
