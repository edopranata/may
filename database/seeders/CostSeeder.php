<?php

namespace Database\Seeders;

use App\Models\Cost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostSeeder extends Seeder
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
                'name'      => 'BBM',
            ],
            1 => [
                'name'      => 'SERVICE',
            ],

        ];
        foreach ($configs as $config) {
            Cost::query()->create($config);
        }
    }
}
