<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Trade;

class TradeObserver
{

    public $afterCommit = false;

    public function created(Trade $trade)
    {
        $trade->user_id  = auth()->id();
        $trade->saveQuietly();

        if($trade->trade_cost > 0){
            $expense = Expense::query()->firstOrCreate([
                'day'   => $trade->trade_date->format('d'),
                'month' => $trade->trade_date->format('m'),
                'year'  => $trade->trade_date->format('Y'),
            ], [
                'date'  => $trade->trade_date
            ]);

            $expense->details()->create([
                'trade_id'      => $trade->id,
                'type'          => 'UANG JALAN',
                'date'          => $trade->trade_date,
                'amount'        => $trade->trade_cost
            ]);

            $expense->increment('balance', $trade->trade_cost);

        }
    }

    public function updated(Trade $trade)
    {
        if($trade->trade_status){
            $income = Income::query()->firstOrCreate([
                'day'   => $trade->trade_status->format('d'),
                'month' => $trade->trade_status->format('m'),
                'year'  => $trade->trade_status->format('Y'),
            ], [
                'date'  => $trade->trade_status
            ]);

            $income->details()->create([
                'trade_id'      => $trade->id,
                'type'          => 'PENJUALAN PABRIK',
                'date'          => $trade->trade_status,
                'amount'        => $trade->net_total
            ]);

            $income->increment('balance', $trade->net_total);
        }
    }
}
