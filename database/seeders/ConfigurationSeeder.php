<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            0 => [
                'name'      => 'driver',
                'value'     => 80
            ],
            1 => [
                'name'      => 'loader',
                'value'     => 45
            ],
            2 => [
                'name'      => 'car',
                'value'     => 100
            ],
            3 => [
                'name'      => 'title',
                'text'      => "RiauCoder's"
            ]
        ];
        $costs = [
            [
                'name'  => 'cost',
                'text'  => 'MINYAK MOBIL'
            ],
            [
                'name'  => 'cost',
                'text'  => 'SERVICE MOBIL'
            ],
        ];

        foreach ($configs as $config) {
            Configuration::query()->create($config);
        }
        foreach ($costs as $cost) {
            Configuration::query()->create($cost);

        }
    }
}
