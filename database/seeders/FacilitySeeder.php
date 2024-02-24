<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\Building;
use App\Models\House;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $facility = Facility::factory()
                ->count(2)
                ->state(new Sequence(
                    ['facility_type' => 'house',],
                    ['facility_type' => 'building'],
                ))
                ->create();
    }
}
