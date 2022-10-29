<?php

namespace App\Http\Controllers\Prints;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class PrintInvoiceFarmerController extends Controller
{

    public function show($id)
    {
        return inertia('Print/Invoice/InvoiceFarmer', [
            'invoice'    =>  Invoice::query()->where('id', $id)->with(['trade_details.trade', 'modelable'])->first()
        ]);
    }
}
