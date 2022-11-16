<?php

namespace App\Http\Controllers\Report\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseDetail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ReportExpenseController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'month' => ['nullable', 'numeric','min:1'],
            'year'  => ['nullable', 'numeric','min:2022', 'max:' . now()->format('Y')]
        ]);
        $date = ($request->year && $request->month) ? Carbon::parse($request->year . '-' . $request->month . '-01') : null;

//        return $this->get_expense('2022-11-01');
        $types = $date ? ExpenseDetail::query()->select('type')
            ->whereMonth('date', $date->format('m'))
            ->whereYear('date', $date->format('Y'))
            ->distinct('type')->get() : [];
        return inertia('Report/Expense/ReportExpenseIndex', [
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

//        Expense::query()->with(['details'])->get()->map(function ($expense){
//            $details = collect($expense->details);
//            return [
//                'date'      => $expense->date,
//                'expense'   => $expense->balance,
//                'details'   => $details->groupBy('type')->map(function ($detail){
//                    return [
//                        'data'  => [
//                            'type'      => $detail[0]->type,
//                            'amount'    => $detail->sum('amount')]
//                    ];
//                })->pluck('data')
//            ];
//        })->toArray();

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

        return collect($incomes);


    }

}
