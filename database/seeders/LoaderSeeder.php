<?php

namespace Database\Seeders;

use App\Models\Loader;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Loader::factory()->times(10)->create([
            'user_id'   => User::query()->first()->id
        ])->each(function ($loader){
            $loader->loan()->create();
            $loader->price()->create([
                'value' => random_int(90, 120)
            ]);
        });;
    }
}
