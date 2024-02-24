<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = User::all()->each( function ($user) {
            Role::factory()
                ->state(
                    ['user_id' => $user->id],
                )
                ->state(new Sequence(
                    ['role' => 'resident'],
                    ['role' => 'admin'],
                ))
                ->create();
        });
    }
}
