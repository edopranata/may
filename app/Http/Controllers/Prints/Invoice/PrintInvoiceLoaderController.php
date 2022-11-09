<?php

namespace App\Http\Controllers\Prints\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class PrintInvoiceLoaderController extends Controller
{

    public function show($id)
    {
        return inertia('Print/Invoice/InvoiceLoader', [
            'invoice'    =>  Invoice::query()->where('id', $id)->with(['trades', 'modelable.price'])->first()
        ]);
    }
}
