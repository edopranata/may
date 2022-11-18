<?php

namespace App\Http\Controllers\Transaction\Trade;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Trade;
use App\Models\TradeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionTradeController extends Controller
{

    public function index()
    {
        return inertia('Transaction/Trade/TradeIndex', [
            'trades'    => Trade::query()->with(['driver', 'car', 'details'])->orderByDesc('created_at')->paginate(),
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

    public function store(Request $request)
    {
        $request->validate([
            'date'          => ['required', 'date'],
            'car_id'        => ['required', 'exists:cars,id'],
            'driver_id'     => ['required', 'exists:drivers,id'],
        ]);

        DB::beginTransaction();
        try {
            $trade = Trade::query()
                ->create([
                    'driver_id'     => $request->driver_id,
                    'car_id'        => $request->car_id,
                    'trade_date'    => $request->date,
                ]);
            DB::commit();
            return redirect()->route('transaction.trade.edit', $trade->id)->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data transaksi berhasil disimpan"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data transaksi gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function edit(Trade $trade)
    {
        return inertia('Transaction/Trade/TradeCreate', [
            'trade'     => $trade->load(['driver', 'car', 'details.farmer']),
            'farmers'   => Farmer::query()->get()->map(function ($farmer) {
                return [
                    'value' => $farmer->id,
                    'label' => $farmer->name . ' (' . $farmer->phone . ')'
                ];
            }),
        ]);
    }

    public function update(Trade $trade, Request $request)
    {
        $request->validate([
            'date'      => ['required', 'date'],
            'farmer_id' => ['required', 'exists:farmers,id'],
            'weight'    => ['required', 'integer', 'min:1'],
            'price'     => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {

            $trade->details()
                ->create([
                    'trade_date'    => $request->date,
                    'farmer_id'     => $request->farmer_id,
                    'weight'        => $request->weight,
                    'price'         => $request->price,
                    'total'         => $request->total,
                ]);

            $trade->withoutEvents(function () use ($trade, $request) {
                $trade->increment('gross_weight', $request->weight);
                $trade->increment('gross_total', $request->total);

                $trade->update(['gross_price' => $trade->details()->avg('price')]);
            });



            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data transaksi berhasil disimpan"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data transaksi gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(TradeDetail $trade, Request $request)
    {

        if($trade->farmer_status){
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data transaksi gagal dihapus karena invoice telah terbit atau telah dibayarkan"
            ]);
        }

        DB::beginTransaction();
        try {
            $decrement = Trade::query()
                ->where('id', $trade->trade_id);

            $decrement->decrement('gross_weight', $trade->weight);
            $decrement->decrement('gross_price', $trade->price);
            $decrement->decrement('gross_total', $trade->total);

            $trade->delete();

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data transaksi berhasil disimpan"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data transaksi gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }
}
