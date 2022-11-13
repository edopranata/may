<?php

namespace App\Observers;

use App\Models\Cost;
use App\Models\Expense;

class CostObserver
{
    public $afterCommit = false;

    public function created(Cost $cost)
    {
        $expense = Expense::query()->firstOrCreate([
            'day'   => $cost->invoice_date->format('d'),
            'month' => $cost->invoice_date->format('m'),
            'year'  => $cost->invoice_date->format('Y'),
        ], [
            'date'  => $cost->invoice_date
        ]);

        $expense->details()->create([
            'cost_id'       => $cost->id,
            'type'          => $cost->name,
            'date'          => $cost->invoice_date,
            'amount'        => $cost->amount
        ]);

        $expense->increment('balance', $cost->amount);
    }
}
