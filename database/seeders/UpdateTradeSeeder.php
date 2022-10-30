<?php

namespace Database\Seeders;

use App\Models\Trade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateTradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trades = Trade::query()
            ->inRandomOrder()
            ->take(rand(30,50))
            ->get();

        foreach ($trades as $trade) {
            $weight = $trade->gross_weight - rand(123,512);
            $price = $trade->_gross_price + 350;
            $trade->update([
                'net_weight'    => $weight,
                'net_price'     => $price,
                'net_total'     => $weight * $price,
                'trade_status'  => $trade->trade_date,
            ]);
        }
    }
}
