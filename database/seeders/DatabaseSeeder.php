<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(FacilitySeeder::class);
        $this->call(HouseSeeder::class);
        $this->call(BuildingSeeder::class);
        $this->call(ApartmentSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(HouseResidentsSeeder::class);
        $this->call(ApartmentResidentsSeeder::class);
    }
}
