<?php

namespace App\Http\Controllers\Transaction\Loan;

use App\Http\Controllers\Controller;

class TransactionLoanController extends Controller
{

    public function index()
    {
        return inertia('Transaction/Loan/TransactionLoanIndex');
    }
}
