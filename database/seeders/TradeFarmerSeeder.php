<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeFarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Farmer::query()->whereHas('trades')->with(['trades'])->chunk(1, function ($farmers){
            foreach ($farmers as $farmer) {
                $trades         = collect($farmer->trades)->pluck('id');
                $total_buy      = collect($farmer->trades)->sum('total');

                $date           = Carbon::parse($farmer->trades->last()->trade_date);
                $sequence       = $this->getLastSequence($date);
                $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

                $invoice = $farmer->invoices()->create([
                    'sequence' => $sequence,
                    'invoice_number' => $invoice_number,
                    'invoice_date' => $date,
                    'total_buy' => $total_buy,
                    'loan' => 0,
                    'loan_installment' => 0,
                    'total' => $total_buy,
                ]);

                $invoice->trade_details()->attach($trades);

                foreach ($farmer->trades as $trade) {
                    $trade->update([
                        'farmer_status' => $date
                    ]);
                }
            }
        });
    }

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
