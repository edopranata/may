<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Loader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
        dd($request->all());
    }
}
