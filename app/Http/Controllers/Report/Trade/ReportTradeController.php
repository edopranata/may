<?php

namespace App\Http\Controllers\Report\Trade;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportTradeController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('post')) {
            $request->validate([
                'start_date' => ['required', 'date', 'min:1'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date', 'max:' . now()->toDateString()]
            ]);
        }

//        $trade = Trade::query()->when($request->start_date, function (Builder $builder, $start_date){
//            $builder->where('trade_date', '>=', $start_date);
//        })->when($request->end_date, function (Builder $builder, $end_date){
//            $builder->where('trade_date', '<=', $end_date);
//        })->with(['details'])->get();

        return inertia('Report/Trade/ReportTradeIndex', [
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'trades'        => ($request->start_date && $request->end_date ) ?
                Trade::query()
                    ->with(['driver', 'car'])
                    ->when($request->start_date, function (Builder $builder, $start_date){
                        $builder->where('trade_date', '>=', $start_date);
                    })->when($request->end_date, function (Builder $builder, $end_date){
                        $builder->where('trade_date', '<=', $end_date);
                    })->withSum('details', 'total')->get() : null,
        ]);
    }
}
