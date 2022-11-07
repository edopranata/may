<?php

namespace App\Http\Controllers\Transaction\Invoice;

use App\Http\Controllers\Controller;

class TransactionInvoiceController extends Controller
{

    public function index()
    {
        return inertia('Transaction/Invoice/InvoiceIndex');
    }
}
