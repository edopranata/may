<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\LoanDetail;

class LoanObserver
{
    public $afterCommit = false;

    public function created(LoanDetail $loan)
    {
        if($loan->amount < 0 ){
            $income = Income::query()->firstOrCreate([
                'day'   => $loan->invoice_date->format('d'),
                'month' => $loan->invoice_date->format('m'),
                'year'  => $loan->invoice_date->format('Y'),
            ], [
                'date'  => $loan->invoice_date
            ]);

            $income->details()->create([
                'loan_detail_id'    => $loan->id,
                'type'              => 'BAYAR PINJAMAN',
                'date'              => $loan->invoice_date,
                'amount'            => $loan->amount * -1
            ]);

            $income->increment('balance', $loan->amount * -1);
        }else{
            $income = Expense::query()->firstOrCreate([
                'day'   => $loan->invoice_date->format('d'),
                'month' => $loan->invoice_date->format('m'),
                'year'  => $loan->invoice_date->format('Y'),
            ], [
                'date'  => $loan->invoice_date
            ]);

            $income->details()->create([
                'loan_detail_id'    => $loan->id,
                'type'              => 'PINJAMAN',
                'date'              => $loan->invoice_date,
                'amount'            => $loan->amount
            ]);

            $income->increment('balance', $loan->amount);
        }
    }
}
