<?php

namespace App\Http\Controllers\Prints\Income;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Income;
use App\Models\IncomeDetail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PrintIncomeController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'month' => ['nullable', 'numeric','min:1'],
            'year'  => ['nullable', 'numeric','min:2022', 'max:' . now()->format('Y')]
        ]);

        $date = ($request->year && $request->month) ? Carbon::parse($request->year . '-' . $request->month . '-01') : null;
        return inertia('Print/Income/IncomeDetails', [
            'types'     => IncomeDetail::query()->select('type')->distinct()->get(),
            'year'      => $request->year,
            'month'     => $request->month,
            'incomes'   => $date ? $this->get_incomes($date) : [],
        ]);
    }

    private function get_all_days($report_date)
    {
        $date = Carbon::parse($report_date);
        $periodes = $periods = CarbonPeriod::create($date->startOfMonth()->toDateString(), $date->endOfMonth()->toDateString());

        return $periods;
    }

    private function get_incomes($date)
    {
        $periods = $this->get_all_days($date);
        $incomes = [];
        $income_collections = collect(Income::query()
            ->whereMonth('date', $periods->first()->format('m'))
            ->whereYear('date', $periods->first()->format('Y'))
            ->get());
        $expense_collections = collect(Expense::query()
            ->whereMonth('date', $periods->first()->format('m'))
            ->whereYear('date', $periods->first()->format('Y'))
            ->get());

        if($income_collections->count() || $expense_collections->count()){
            foreach ($periods as $period) {
                $income_balance = $income_collections->where('day', $period->format('d'))->where('month', $period->format('m'))->where('year', $period->format('Y'))->sum('balance');
                $expense_balance = $expense_collections->where('day', $period->format('d'))->where('month', $period->format('m'))->where('year', $period->format('Y'))->sum('balance');
                if($period->lte(now())){
                    $incomes[] = array(
                        'date'          => $period->format('d F Y'),
                        'income'        => $income_balance,
                        'expense'       => $expense_balance,
                        'net_income'    => $income_balance - $expense_balance
                    );
                }
            }
        }

        return collect($incomes);


    }
}
