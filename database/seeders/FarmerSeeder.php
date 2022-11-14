<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\LoanDetail;
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

    use WithoutModelEvents;
    public function run()
    {
        Farmer::factory()->times(200)->create([
            'user_id'   => User::query()->first()->id
        ])
            ->each( function ($farmer, $index){
//            $one = [100000, 200000, 300000];
//            $two = [5,10,15];
//            $balance = $one[array_rand($one)] * ($two[array_rand($two)] + 5) + $one[array_rand($one)];
            $farmer->loan()->create();
//
//            $sequence       = $index + 1;
//            $invoice_number = 'MM-P' . now()->format('Y') . sprintf('%06d', $sequence);

//            $farmer->loan->details()->create([
//                'invoice_date'      => now()->toDateString(),
//                'sequence'          => $sequence,
//                'invoice_number'    => $invoice_number,
//                'description'       => 'Pinjaman ' . now()->format('d F Y'),
//                'opening_balance'   => $farmer->loan->balance,
//                'amount'            => $balance,
//                'status'            => 'PINJAM'
//            ]);
//            $farmer->loan()->increment('balance', $balance);
        });
    }

}
