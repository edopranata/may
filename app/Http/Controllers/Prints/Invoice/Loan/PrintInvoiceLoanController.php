<?php

namespace App\Http\Controllers\Prints\Invoice\Loan;

use App\Http\Controllers\Controller;
use App\Models\LoanDetail;
use Illuminate\Http\Request;

class PrintInvoiceLoanController extends Controller
{
    public function show($id)
    {
        return inertia('Print/Invoice/Loan/InvoiceLoan', [
            'invoice'   => LoanDetail::query()
                ->with(['loan.modelable'])
                ->where('id', $id)->first()
        ]);
//        dd($loan);
    }
}
