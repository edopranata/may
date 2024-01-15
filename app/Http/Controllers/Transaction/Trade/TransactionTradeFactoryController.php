<?php

namespace App\Http\Controllers\Transaction\Trade;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Invoice;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionTradeFactoryController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Trade/Factory/TradeFactoryIndex', [
            'driver_id' => $request->driver_id,
            'car_id'    => $request->car_id,
            'date'      => $request->date,
            'trades'    => Trade::query()
                ->when($request->date, function (Builder $builder, $value){
                    $builder->where('trade_date', $value);
                })
                ->when($request->driver_id, function (Builder $builder, $value){
                    $builder->where('driver_id', $value);
                })
                ->when($request->car_id, function (Builder $builder, $value){
                    $builder->where('car_id', $value);
                })
                ->whereNull('trade_status')
                ->with(['driver', 'car', 'details'])
                ->orderByDesc('created_at')->paginate(),
            'drivers'   => Driver::query()->get()->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'text' => $driver->name . ' (' . $driver->phone . ')'
                ];
            }),
            'cars'      => Car::query()->get()->map(function ($car) {
                return [
                    'id' => $car->id,
                    'text' => $car->no_pol . ' - ' . $car->name
                ];
            }),
        ]);
    }

    public function show(Trade $factory)
    {
        return inertia('Transaction/Trade/Factory/TradeFactoryCreate', [
            'trade'     => $factory->load(['driver.price', 'car.price', 'details.farmer']),
        ]);
    }

    public function update(Trade $factory, Request $request)
    {
        $request->validate([
            'weight'    => ['required', 'integer', 'min:1'],
            'price'     => ['required', 'integer', 'min:' . $factory->gross_price],
        ]);

        DB::beginTransaction();
        try {
            $factory->load('car');
            $factory->update([
                'net_weight'    => $request->weight,
                'net_price'     => $request->price,
                'net_total'     => $request->total,
                'car_fee'       => $request->car_fee,
                'car_status'    => $factory->trade_date,
                'trade_status'  => now()->toDateTimeString(),
            ]);

            $date           = Carbon::parse($factory->trade_date);
            $sequence       = $this->getLastSequence($factory->trade_date);
            $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

            // create invoice for car
            $invoice = $factory->car->invoices()->create([
                'sequence' => $sequence,
                'invoice_number' => $invoice_number,
                'invoice_date' => $factory->trade_date,
                'total_buy' => $request->car_price,
                'total' => $request->car_price,
            ]);

            $invoice->trades()->attach($factory);

            DB::commit();
            return redirect()->route('transaction.factory.index')->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Transaksi timbangan pakbrik berhasil disimpan"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Transaksi timbangan pakbrik gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
