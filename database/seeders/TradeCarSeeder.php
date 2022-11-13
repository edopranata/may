<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Configuration;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $car_fee = Configuration::query()->where('name', 'car')->first()->value;
        $cars = Car::query()->with(['trades'])->whereHas('trades')->chunk(1, function ($cars) use ($car_fee) {
            foreach ($cars as $car) {
                $trades         = collect($car->trades)->pluck('id');
                $total          = collect($car->trades)->sum('net_weight') * $car_fee;

                $date           = Carbon::parse($car->trades->last()->trade_date);
                $sequence       = $this->getLastSequence($date);
                $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

                $invoice = $car->invoices()->create([
                    'sequence' => $sequence,
                    'invoice_number' => $invoice_number,
                    'invoice_date' => $date,
                    'total_buy' => $total,
                    'total' => $total,
                ]);

                $invoice->trades()->attach($trades);

                $invoice->trades()->update([
                    'car_status' => $date,
                    'car_fee'    => $car_fee
                ]);
            }
        });
    }

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
