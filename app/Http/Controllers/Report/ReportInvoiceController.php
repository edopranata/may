<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class ReportInvoiceController extends Controller
{

    public function index()
    {
        return inertia('Report/Invoice/ReportInvoiceIndex');

    }
}
