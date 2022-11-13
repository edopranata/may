<?php

namespace Database\Seeders;

use App\Models\Trade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trades = Trade::query()
            ->get();

        foreach ($trades as $trade) {
            $weight = $trade->gross_weight - rand(123,512);
            $price = round($trade->gross_price, 0) + 350;
            $trade->update([
                'net_weight'    => $weight,
                'net_price'     => $price,
                'net_total'     => $weight * $price,
                'trade_status'  => $trade->trade_date,
            ]);
        }
    }
}
