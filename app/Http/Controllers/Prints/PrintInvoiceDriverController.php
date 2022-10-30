<?php

namespace App\Http\Controllers\Prints;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class PrintInvoiceDriverController extends Controller
{

    public function show($id)
    {
//        dd(Invoice::query()->where('id', $id)->with(['trades', 'modelable.price'])->first());
        return inertia('Print/Invoice/InvoiceDriver', [
            'invoice'    =>  Invoice::query()->where('id', $id)->with(['trades', 'modelable.price'])->first()
        ]);
    }
}
