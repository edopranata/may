<?php

namespace App\Http\Controllers\Prints;

use App\Http\Controllers\Controller;

class PrintInvoiceController extends Controller
{

    public function index()
    {
        return to_route('dashboard.index');
    }
}
