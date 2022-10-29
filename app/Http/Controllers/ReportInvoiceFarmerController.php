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
            'farmer'        => $request->farmer,
            'invoices'      =>  Invoice::query()
                    ->when($request->invoice, function (Builder $builder, $invoice){
                        $builder->where('invoice_number', 'like', '%' . $invoice . '%');
                    })
                        ->with(['trade_details.trade', 'modelable'])->whereHasMorph('modelable', [Farmer::class], function (Builder $builder) use ($request){
                        $builder->filter($request->farmer);
                })
                ->paginate()
                ->withQueryString()
        ]);
    }
}
