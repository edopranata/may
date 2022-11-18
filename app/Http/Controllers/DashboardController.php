<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Configuration;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\Farmer;
use App\Models\Income;
use App\Models\Invoice;
use App\Models\Loader;
use App\Models\Loan;
use App\Models\Trade;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{

    public function index()
    {
        $loan = Loan::query();
        return inertia('Dashboard/DashboardIndex', [
            'loan'       => $loan->sum('balance'),
            'loans'      => $loan->groupBy('modelable_type')->selectRaw('sum(balance) as balance, modelable_type')->get()->map(function ($loan) {
                return [
                    'balance'   => $loan->balance,
                    'name'      => $this->getType($loan->modelable_type)
                ];
            }),
            'income'    => Income::query()->whereMonth('date', now()->format('m'))->whereYear('date', now()->format('Y'))->sum('balance'),
            'expense'   => Expense::query()->whereMonth('date', now()->format('m'))->whereYear('date', now()->format('Y'))->sum('balance')
        ]);
    }

    private function getType($modelable_type)
    {
        $model = collect(explode('\\', $modelable_type))->last();

        switch ($model) {
            case "Farmer":
                return 'petani';
            case "Driver":
                return 'supir';
            case "Loader":
                return 'tukang muat';
            case "Supervisor":
                return 'mandor';
            default:
                return 'other';
        }

    }

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;
    }

    public function trade_reset()
    {
        Artisan::call('migrate:fresh', ['--seed' => true]);
        return redirect()->back()->with('alert', [
            'type'    => 'success',
            'title'   => 'Success',
            'message' => "Refresh Database Sukses"
        ]);
    }

    public function trade_create()
    {
        $periods = CarbonPeriod::create('2022-10-01', now()->format('Y-m-d'));
        foreach ($periods as $period) {
            Trade::factory()->times(rand(2,5))->create([
                'trade_date' => $period
            ])->each(function ($trade) use ($period){
                $farmers = Farmer::query()->inRandomOrder()->take(rand(3,10))->get();
                foreach ($farmers as $farmer) {
                    $weight = random_int(500, 1500);
                    $one = [1200, 1300, 1400, 1500];
                    $two = [10, 20,30,40,50,60,70,80,90];
                    $price = $one[array_rand($one)] + $two[array_rand($two)];
                    $trade->details()
                        ->create([
                            'trade_date'    => $period,
                            'farmer_id'     => $farmer->id,
                            'weight'        => $weight,
                            'price'         => $price,
                            'total'         => $weight * $price,
                        ]);
                    $trade->increment('gross_weight', $weight);
                    $trade->increment('gross_total', $weight * $price);
                }
                $trade->update(['gross_price' => $trade->details()->avg('price')]);
            });
        }

        return redirect()->back()->with('alert', [
            'type'    => 'success',
            'title'   => 'Success',
            'message' => "Insert Dummy data untuk transaksi pembelian sawit sukses"
        ]);
    }

    public function trade_factory()
    {
        Trade::query()
            ->chunk(1, function ($trades){
                foreach ($trades as $trade) {
                    $weight = $trade->gross_weight + rand(100,300);
                    $price = round($trade->gross_price, 0) + 370;
                    $trade->update([
                        'net_weight'    => $weight,
                        'net_price'     => $price,
                        'net_total'     => $weight * $price,
                        'trade_status'  => $trade->trade_date,
                    ]);
                }
            });

        return redirect()->back()->with('alert', [
            'type'    => 'success',
            'title'   => 'Success',
            'message' => "Update Dummy data untuk transaksi penjualan ke pabrik sukses"
        ]);
    }

    public function trade_update()
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

        return redirect()->back()->with('alert', [
            'type'    => 'success',
            'title'   => 'Success',
            'message' => "Buat invoice pembayaran (petani, gaji supir, amprah mobil, upah muat) sukses"
        ]);
    }
}
