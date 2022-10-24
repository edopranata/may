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
                'value'     => 100
            ],
            1 => [
                'name'      => 'loader',
                'value'     => 80
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
        foreach ($configs as $config) {
            Configuration::query()->create($config);
        }
    }
}
