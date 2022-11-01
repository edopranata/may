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
        Loader::query()->create([
            'user_id'   => User::query()->first()->id,
            'name'      => 'Tukang Muat'
        ])->each(function ($loader){
            $loader->price()->create([
                'value' => 45
            ]);
        });
    }
}
