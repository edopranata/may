<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
//        dd(Income::query()->whereMonth('date', now()->format('m'))->whereYear('date', now()->format('y'))->sum('balance'));
        return inertia('Dashboard/DashboardIndex', [
            'income'    => Income::query()->whereMonth('date', now()->format('m'))->whereYear('date', now()->format('Y'))->sum('balance'),
            'expense'   => Expense::query()->whereMonth('date', now()->format('m'))->whereYear('date', now()->format('Y'))->sum('balance')

        ]);
    }
}
