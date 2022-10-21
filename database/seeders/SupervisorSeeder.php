<?php

namespace Database\Seeders;

use App\Models\Loader;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supervisor::factory()->times(10)->create([
            'user_id'   => User::query()->first()->id
        ])->each(function ($supervisor){
            $supervisor->loan()->create();
        });;
    }
}
