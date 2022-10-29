<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Trade;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $periods = CarbonPeriod::create('2022-10-01', '2022-10-30');
        foreach ($periods as $period) {
            Trade::factory()->times(rand(2,5))->create([
                'trade_date' => $period
            ])->each(function ($trade) use ($period){
                $farmers = Farmer::query()->inRandomOrder()->take(rand(5,20))->get();
                foreach ($farmers as $farmer) {
                    $weight = random_int(500, 1500);
                    $one = [1200, 1300, 1400, 1500];
                    $two = [10, 20,30,40,50,60,70,80,90];
                    $price = $one[array_rand($one)] + $two[array_rand($two)];
                    $trade->details()
                        ->create([
                            'trade_date'    => $period,
                            'farmer_id'     => $farmer->id,
                            'weight'        => $weight,
                            'price'         => $price,
                            'total'         => $weight * $price,
                        ]);
                    $trade->increment('gross_weight', $weight);
                    $trade->increment('gross_total', $weight * $price);
                }
                $trade->update(['gross_price' => $trade->details()->avg('price')]);

            });
        }
    }
}
