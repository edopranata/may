<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;

class TransactionController extends Controller
{

    public function index()
    {
        return inertia('Transaction/TransactionIndex');
    }
}
