<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->unique()->word(),
            'no_pol'        => 'BM ' . $this->faker->randomNumber(4, true) . ' ' . mb_strtoupper(substr($this->faker->words(2, true), 0, '2')),
            'year'          => $this->faker->year(2021),
            'description'   => $this->faker->words(10, true),
        ];
    }
}
