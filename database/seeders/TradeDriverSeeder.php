<?php

namespace Database\Seeders;

use App\Models\Configuration;
use App\Models\Driver;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeDriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $driver_fee = Configuration::query()->where('name', 'driver')->first()->value;

        $drivers = Driver::query()->with(['trades'])->whereHas('trades')->chunk(1, function ($drivers) use ($driver_fee) {
            foreach ($drivers as $driver) {
                $trades         = collect($driver->trades)->pluck('id');
                $total          = collect($driver->trades)->sum('net_weight') * $driver_fee;

                $date           = Carbon::parse($driver->trades->last()->trade_date);
                $sequence       = $this->getLastSequence($date);
                $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

                $invoice = $driver->invoices()->create([
                    'sequence' => $sequence,
                    'invoice_number' => $invoice_number,
                    'invoice_date' => $date,
                    'total_buy' => $total,
                    'total' => $total,
                ]);

                $invoice->trades()->attach($trades);

                $invoice->trades()->update([
                    'driver_status' => $date,
                    'driver_fee'    => $driver_fee
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
