<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PrintInvoiceFarmerController extends Controller
{

    public function show($id)
    {
        return inertia('Print/Invoice/InvoiceFarmer', [
            'invoice'    =>  Invoice::query()->where('id', $id)->with(['trades', 'modelable'])->first()
        ]);
    }
}
