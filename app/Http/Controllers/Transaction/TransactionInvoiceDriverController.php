<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Trade;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionInvoiceDriverController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Driver/InvoiceDriverIndex', [
            'driver_id' => $request->driver_id,
            'drivers'   => Driver::query()->get()->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'text' => $driver->name . ' (' . $driver->phone . ')'
                ];
            }),
            'trades'    => Trade::query()
                ->whereNotNull('trade_status')
                ->when($request->driver_id, function (Builder $builder, $value){
                    $builder->where('driver_id', $value);
                })
                ->with(['driver.price', 'car', 'details'])
                ->orderByDesc('created_at')->paginate(),

        ]);
    }
}
