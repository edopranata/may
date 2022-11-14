<?php

namespace App\Http\Controllers\Report\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Invoice;
use App\Models\Loader;
use App\Models\LoanDetail;
use App\Models\Supervisor;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportInvoiceLoanController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Report/Invoice/ReportInvoiceLoanIndex', [
            'search'        => $request->search,
            'invoices'      =>  LoanDetail::query()
                ->when($request->invoice, function (Builder $builder, $invoice){
                    $builder->where('invoice_number', 'like', '%' . $invoice . '%');
                })
                ->with(['loan' => function(Builder $builder) use ($request) {
                    $builder->with(['modelable'])->whereHasMorph(
                        'modelable', [Farmer::class, Driver::class, Supervisor::class], function (Builder $builder) use ($request){
                        $builder->filter($request->search);
                    });
                }])
                ->orderByDesc('created_at')
                ->paginate()
                ->withQueryString()
                ->through( function ($invoice) {

                    return [
                        'id'                => $invoice->id,
                        'invoice_number'    => $invoice->invoice_number,
                        'type'              => $this->getType($invoice->loan->modelable_type, $invoice->id),
                        'invoice_date'      => $invoice->invoice_date->format('d F Y'),
                        'opening_balance'   => $invoice->opening_balance,
                        'amount'            => $invoice->amount,
                        'status'            => $invoice->status,
                        'loan'              => $invoice->loan,
                    ];
                })
        ]);
    }

    private function getType($modelable_type, $id)
    {
        $model = collect(explode('\\', $modelable_type))->last();

        switch ($model){
            case "Farmer":
                return [
                    'name'          => 'farmer',
                    'title'         => 'Pinjaman Petani',
                    'badge'         => 'badge-primary',
                    'url_print'     => route('print.invoice.loan.show', $id)
                ];
            case "Driver":
                return [
                    'name'          => 'driver',
                    'title'         => 'Pinjaman Supir',
                    'badge'         => 'badge-success',
                    'url_print'     => route('print.invoice.loan.show', $id)
                ];
            case "Supervisor":
                return [
                    'name'          => 'supervisor',
                    'title'         => 'Pinjaman Mandor',
                    'badge'         => 'badge-info',
                    'url_print'     => route('print.invoice.loan.show', $id)
                ];
            default:
                return $model;
        }
    }

}
