<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceObserver
{

    public $afterCommit = false;

    public function created(Invoice $invoie)
    {
        $invoie->user_id  = auth()->id();
        $invoie->save();
    }

    public function updated(Invoice $invoice)
    {
        $expense = Expense::query()->firstOrCreate([
            'day'   => $invoice->invoice_date->format('d'),
            'month' => $invoice->invoice_date->format('m'),
            'year'  => $invoice->invoice_date->format('Y'),
        ], [
            'date'  => $invoice->invoice_date
        ]);

        $type = collect(explode('\\', $invoice->modelable_type));

        $expense_type = null;
        switch (str($type->last())->lower()){
            case "driver":
                $expense_type = "BAYAR SUPIR";
            break;
            case "car":
                $expense_type = "AMPRAH MOBIL";
                break;
            case "farmer":
                $expense_type = "BAYAR PETANI";
                break;
            case "loader":
                $expense_type = "BAYAR TUKANG MUAT";
                break;
            default:
                $expense_type = null;
        }

        $expense->details()->create([
            'invoice_id'    => $invoice->id,
            'type'          => $expense_type,
            'date'          => $invoice->invoice_date,
            'amount'        => $invoice->total
        ]);

        $expense->increment('balance', $invoice->total);
//        dd($expense_type);
    }
}
