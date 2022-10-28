<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\Invoice;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportInvoiceFarmerController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Report/Invoice/ReportInvoiceFarmerIndex', [
            'invoices'    =>  Invoice::query()->with(['trade_details.trade', 'modelable'])
                ->paginate()
                ->withQueryString()
        ]);
    }
}
