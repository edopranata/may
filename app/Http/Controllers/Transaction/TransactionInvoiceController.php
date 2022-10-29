<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;

class TransactionInvoiceController extends Controller
{

    public function index()
    {
        return inertia('Transaction/Invoice/InvoiceIndex');
    }
}
