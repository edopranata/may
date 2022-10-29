<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintInvoiceController extends Controller
{

    public function index()
    {
        return to_route('dashboard.index');
    }
}
