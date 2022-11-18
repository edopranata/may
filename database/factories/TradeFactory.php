<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Driver;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trade>
 */
class TradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'trade_date'    => Carbon::now(),
            'trade_cost'    => $this->faker->randomElement([120000,130000,140000,150000,160000]),
            'driver_id'     => Driver::query()->inRandomOrder()->first()->id,
            'user_id'       => User::query()->inRandomOrder()->first()->id,
            'car_id'        => Car::query()->inRandomOrder()->first()->id,
        ];
    }
}
