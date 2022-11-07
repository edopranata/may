<?php

namespace App\Http\Controllers\Prints;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PrintInvoiceLoaderController extends Controller
{

    public function show($id)
    {
        return inertia('Print/Invoice/InvoiceLoader', [
            'invoice'    =>  Invoice::query()->where('id', $id)->with(['trades', 'modelable.price'])->first()
        ]);
    }
}
