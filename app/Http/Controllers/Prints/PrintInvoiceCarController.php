<?php

namespace App\Http\Controllers\Prints;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PrintInvoiceCarController extends Controller
{

    public function show($id)
    {
        return inertia('Print/Invoice/InvoiceCar', [
            'invoice'    =>  Invoice::query()->where('id', $id)->with(['trades', 'modelable.price'])->first()
        ]);
    }
}
