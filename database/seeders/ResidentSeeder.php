<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resident;


class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resident::factory()->count(10)->create();

        Resident::factory()->make([
            'name'=> 'Zhya Rebwar',
        ]);

    }
}
