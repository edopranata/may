<?php

namespace App\Http\Controllers\Prints\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseDetail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PrintExpenseController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'month' => ['required', 'numeric','min:1'],
            'year'  => ['required', 'numeric','min:2022', 'max:' . now()->format('Y')]
        ]);
        $date = ($request->year && $request->month) ? Carbon::parse($request->year . '-' . $request->month . '-01') : null;

        $types = $date ? ExpenseDetail::query()->selectRaw("sum(amount) balance, type")
            ->whereMonth('date', $date->format('m'))
            ->whereYear('date', $date->format('Y'))
            ->groupby('type')
            ->get() : [];

        return inertia('Print/Expense/ExpenseDetails', [
            'types'     => $types,
            'year'      => $request->year,
            'month'     => $request->month,
            'expenses'  => $date ? $this->get_expense($date) : [],
        ]);
    }

    private function get_all_days($report_date)
    {
        $date = Carbon::parse($report_date);
        $periodes = $periods = CarbonPeriod::create($date->startOfMonth()->toDateString(), $date->endOfMonth()->toDateString());

        return $periods;
    }

    private function get_expense($date)
    {
        $periods = $this->get_all_days($date);
        $incomes = [];
        $expense_collections = collect(Expense::query()->with(['details'])
            ->whereMonth('date', $periods->first()->format('m'))
            ->whereYear('date', $periods->first()->format('Y'))
            ->get()->map(function ($expense){
                $details = collect($expense->details);
                return [
                    'day'       => $expense->day,
                    'month'     => $expense->month,
                    'year'      => $expense->year,
                    'date'      => $expense->date,
                    'balance'   => $expense->balance,
                    'details'   => $details->groupBy('type')->map(function ($detail){
                        return [
                            'data'  => [
                                'type'      => $detail[0]->type,
                                'amount'    => $detail->sum('amount')]
                        ];
                    })->pluck('data')
                ];
            })->toArray());

        if($expense_collections->count()){
            foreach ($periods as $period) {
                $expense_balance = $expense_collections->where('day', $period->format('d'))->where('month', $period->format('m'))->where('year', $period->format('Y'));
                if($period->lte(now())){
                    $incomes[] = array(
                        'date'          => $period->format('d F Y'),
                        'expense'       => $expense_balance->first(),
                    );
                }
            }
        }

//        dd($incomes);
        return collect($incomes);
    }
}
