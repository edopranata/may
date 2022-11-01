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
        Supervisor::query()->create([
            'user_id'   => User::query()->first()->id,
            'name'      => 'Nama Mandor',
            'phone'     => '08123456789',
        ])->each(function ($supervisor){
            $supervisor->price()->create([
                'value' => 5600000
            ]);
        });
    }
}
