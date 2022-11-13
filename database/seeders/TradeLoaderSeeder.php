<?php

namespace Database\Seeders;

use App\Models\Configuration;
use App\Models\Invoice;
use App\Models\Loader;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeLoaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loader_fee         = Configuration::query()->where('name', 'loader')->first()->value;
        $loader_trades      = Trade::query()
            ->whereNotNull('trade_status')
            ->whereNull('loader_status')->get();

        $trades         = collect($loader_trades)->pluck('id');
        $total          = collect($loader_trades)->sum('net_weight') * $loader_fee;

        $date           = Carbon::parse($loader_trades->last()->trade_date);
        $sequence       = $this->getLastSequence($date);
        $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

        $invoice = Loader::query()->first()->invoices()->create([
            'sequence' => $sequence,
            'invoice_number' => $invoice_number,
            'invoice_date' => $date,
            'total_buy' => $total,
            'total' => $total,
        ]);

        $invoice->trades()->attach($trades);

        $invoice->trades()->update([
            'loader_status' => $date,
            'loader_fee'    => $loader_fee
        ]);

    }

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
