<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Loan;

class DashboardController extends Controller
{

    public function index()
    {
        $loan = Loan::query();
        return inertia('Dashboard/DashboardIndex', [
            'loan'       => $loan->sum('balance'),
            'loans'      => $loan->groupBy('modelable_type')->selectRaw('sum(balance) as balance, modelable_type')->get()->map(function ($loan) {
                return [
                    'balance'   => $loan->balance,
                    'name'      => $this->getType($loan->modelable_type)
                ];
            }),
            'income'    => Income::query()->whereMonth('date', now()->format('m'))->whereYear('date', now()->format('Y'))->sum('balance'),
            'expense'   => Expense::query()->whereMonth('date', now()->format('m'))->whereYear('date', now()->format('Y'))->sum('balance')
        ]);
    }

    private function getType($modelable_type)
    {
        $model = collect(explode('\\', $modelable_type))->last();

        switch ($model) {
            case "Farmer":
                return 'petani';
            case "Driver":
                return 'supir';
            case "Loader":
                return 'tukang muat';
            case "Supervisor":
                return 'mandor';
            default:
                return 'other';
        }

    }
}
