<?php

namespace Database\Seeders;

use App\Models\ApartmentResidents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Apartment;

class ApartmentResidentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'messi@gmail.com')->first();

        $user_houses = Apartment::all()->each( function($house) use ($user) {
            ApartmentResidents::create([
                'house_id' => $house->id,
                'resident_id' => $user->id,
            ]);
        });
    }
}
