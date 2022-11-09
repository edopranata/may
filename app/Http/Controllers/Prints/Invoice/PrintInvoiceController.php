<?php

namespace App\Http\Controllers\Prints\Invoice;

use App\Http\Controllers\Controller;

class PrintInvoiceController extends Controller
{

    public function index()
    {
        return to_route('dashboard.index');
    }
}
