<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farmer>
 */
class FarmerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->unique()->name(),
            'phone'     => $this->faker->phoneNumber(),
            'address'   => $this->faker->address(),
            'distance'  => $this->faker->randomNumber(2, true)
        ];
    }
}
