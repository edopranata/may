<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionLoanController extends Controller
{

    public function index()
    {
        return inertia('Transaction/Loan/TransactionLoanIndex');
    }
}
