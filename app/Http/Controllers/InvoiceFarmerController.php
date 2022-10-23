<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\Trade;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceFarmerController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Farmer/InvoiceFarmerIndex', [
            'farmers'    =>  Farmer::query()->with(['loan'])
                ->when($request->search, function (\Illuminate\Database\Eloquent\Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('address', 'like', '%'.$value.'%')
                    ->orWhere('phone', 'like', '%'.$value.'%');
                })
                ->whereHas('trades')
                ->withCount('trades')
                ->withCount([
                    'trades AS trades_total' => function (Builder $query) {
                        $query->select(DB::raw("SUM(total_buy) as total"))->whereNull('farmer_status');
                    }
                ])->paginate(5)
                ->withQueryString()
                ->through(fn ($farmer) => [
                    'id'            => $farmer->id,
                    'name'          => $farmer->name,
                    'address'       => $farmer->address,
                    'distance'      => $farmer->distance,
                    'phone'         => $farmer->phone,
                    'trades_total'  => $farmer->trades_total,
                    'trades_count'  => $farmer->trades_count,
                    'loan_total'    => $farmer->loan ? $farmer->loan->balance : 0
                ])

        ]);
    }

    public function show(Farmer $farmer)
    {
        return inertia('Transaction/Invoice/Farmer/InvoiceFarmerView', [
            'farmer'    =>  $farmer->load(['loan', 'trades'])
                ->loadCount('trades')
                ->loadCount([
                'trades AS trades_total' => function (Builder $query) {
                    $query->select(DB::raw("SUM(total_buy) as total"))->whereNull('farmer_status');
                }
            ])

        ]);
    }
}
