<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Invoice;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
