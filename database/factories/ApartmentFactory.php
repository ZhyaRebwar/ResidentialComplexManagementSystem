<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'floor' => fake()->numberBetween(1,10),
            'name' => fake()->randomLetter() . fake()->numberBetween(0,100),
            'electricity_unit' => fake()->numberBetween(100,1000),
        ];
    }
}
