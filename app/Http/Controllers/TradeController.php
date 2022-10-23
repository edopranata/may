<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Loader;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TradeController extends Controller
{

    public function index()
    {
        return inertia('Transaction/Trade/TradeIndex', [
            'farmers'   => Farmer::query()->get()->map(function ($farmer){
                return [
                    'id'    => $farmer->id,
                    'text'  => $farmer->name . ' (' . $farmer->phone . ')'
                ];
            }),
            'drivers' => Driver::query()->get()->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'text' => $driver->name . ' (' . $driver->phone . ')'
                ];
            }),
            'loaders' => Loader::query()->get()->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'text' => $driver->name
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'          => ['required', 'date'],
            'farmer_id'     => ['required', 'exists:farmers,id'],
            'buying_price'  => ['required', 'numeric', 'min:1'],
            'gross_weight'  => ['required', 'numeric', 'min:1'],
            'selling_price' => ['required', 'numeric', 'min:1'],
            'net_weight'    => ['required', 'numeric', 'min:1'],
            'description'   => ['nullable'],
            'driver_id'     => ['required', 'exists:drivers,id'],
            'loaders'       => ['required', 'array', 'min:1'],
        ]);
        $loaders = collect($request->loaders)->pluck('id');

        $tbs_loaders = Loader::query()->with('price')->whereIn('id', $loaders)->get();

        $driver = Driver::query()->with('price')->where('id', $request->driver_id)->first();

        DB::beginTransaction();
        try {
            $trade = Trade::query()
                ->create([
                    'driver_id'     => $request->driver_id,
                    'farmer_id'     => $request->farmer_id,
                    'trade_date'    => $request->date,
                    'buying_price'  => $request->buying_price,
                    'gross_weight'  => $request->gross_weight,
                    'selling_price' => $request->selling_price,
                    'net_weight'    => $request->net_weight,
                    'total_buy'     => $request->buying_price * $request->net_weight,
                    'total_sell'    => $request->selling_price * $request->net_weight,
                    'description'   => $request->description,
                    'driver_fee'    => $driver->price ? $driver->price->value : 0,
                ]);
            foreach ($tbs_loaders as $tbs_loader) {
                $trade->loaders()->create([
                    'loader_id'     => $tbs_loader->id,
                    'net_weight'    => $request->net_weight,
                    'price'         => $tbs_loader->price ? $tbs_loader->price->value : 0,
                ]);
            }

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
