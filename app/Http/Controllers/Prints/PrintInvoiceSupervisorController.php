<?php

namespace App\Http\Controllers\Prints;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PrintInvoiceSupervisorController extends Controller
{
    public function show($id)
    {
        return inertia('Print/Invoice/InvoiceSupervisor', [
            'invoice'    =>  Invoice::query()->where('id', $id)->with(['modelable.price'])->first()
        ]);
    }
}
