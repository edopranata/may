<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UserSeeder::class,
            FarmerSeeder::class,
            CarSeeder::class,
            LoaderSeeder::class,
            DriverSeeder::class,
            SupervisorSeeder::class,
            ConfigurationSeeder::class,
//            TradeCreateSeeder::class,
//            TradeUpdateSeeder::class,
        ]);
    }
}
