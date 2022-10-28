<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportInvoiceController extends Controller
{

    public function index()
    {
        return inertia('Report/Invoice/ReportInvoiceIndex');

    }
}
