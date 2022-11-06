<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Invoice;
use App\Models\Trade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_trades = Trade::query()->take(rand(5,10))->get();
        $trades = $data_trades->pluck('id');
        $total_buy = $data_trades->sum('total');

        $sequence       = $this->getLastSequence();
        $invoice_number = 'MM' . now()->format('Y') . sprintf('%08d', $sequence);
    }

    private function getLastSequence() {
        $invoice = Invoice::query()->whereYear('invoice_date', now()->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
