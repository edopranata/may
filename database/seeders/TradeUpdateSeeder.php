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
        $this->call([
            TradeFarmerSeeder::class,
            TradeCarSeeder::class,
            TradeDriverSeeder::class,
            TradeLoaderSeeder::class
        ]);


    }
}
