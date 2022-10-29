<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Farmer::factory()->times(200)->create([
            'user_id'   => User::query()->first()->id
        ])->each(function ($farmer){
            $farmer->loan()->create();
        });
    }
}
