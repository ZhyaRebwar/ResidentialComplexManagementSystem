<?php

namespace Database\Seeders;

use App\Models\House;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HouseResidents;

class HouseResidentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'messi@gmail.com')->first();

        $user_houses = House::all()->each( function($house) use ($user) {
            HouseResidents::create([
                'house_id' => $house->id,
                'resident_id' => $user->id,
            ]);
        });

    }
}
