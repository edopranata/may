<?php

namespace App\Http\Controllers\Report\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Invoice;
use App\Models\Loader;
use App\Models\Supervisor;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportInvoiceController extends Controller
{

    private function getType($modelable_type, $id)
    {
        $model = collect(explode('\\', $modelable_type))->last();

        switch ($model){
            case "Farmer":
                return [
                    'name'          => 'farmer',
                    'title'         => 'Invoice Petani',
                    'badge'         => 'badge-primary',
                    'url_print'     => route('print.invoice.farmer.show', $id)
                ];
            case "Driver":
                return [
                    'name'          => 'driver',
                    'title'         => 'Gaji Supir',
                    'badge'         => 'badge-success',
                    'url_print'     => route('print.invoice.driver.show', $id)
                ];
            case "Car":
                return [
                    'name'          => 'car',
                    'title'         => 'Amprah Mobil',
                    'badge'         => 'badge-secondary',
                    'url_print'     => route('print.invoice.car.show', $id)
                ];
            case "Loader":
                return [
                    'name'          => 'loader',
                    'title'         => 'Upah Muat',
                    'badge'         => 'badge-error',
                    'url_print'     => route('print.invoice.loader.show', $id)
                ];
            case "Supervisor":
                return [
                    'name'          => 'supervisor',
                    'title'         => 'Gaji Mandor',
                    'badge'         => 'badge-info',
                    'url_print'     => route('print.invoice.supervisor.show', $id)
                ];
            default:
                return $model;
        }
    }

    public function index(Request $request)
    {
        return inertia('Report/Invoice/ReportInvoiceIndex', [
            'search'        => $request->search,
            'invoices'      =>  Invoice::query()
                ->when($request->invoice, function (Builder $builder, $invoice){
                    $builder->where('invoice_number', 'like', '%' . $invoice . '%');
                })
                ->with(['modelable'])->whereHasMorph(
                    'modelable', [Farmer::class, Car::class, Driver::class, Loader::class, Supervisor::class], function (Builder $builder) use ($request){
                    $builder->filter($request->search);
                })
                ->orderByDesc('created_at')
                ->paginate()
                ->withQueryString()
                ->through( function ($invoice) {

                    return [
                        'id'                => $invoice->id,
                        'invoice_number'    => $invoice->invoice_number,
                        'type'              => $this->getType($invoice->modelable_type, $invoice->id),
                        'invoice_date'      => $invoice->invoice_date->format('d F Y'),
                        'total_buy'         => $invoice->total_buy,
                        'loan'              => $invoice->loan,
                        'loan_installment'  => $invoice->loan_installment,
                        'total'             => $invoice->total,
                        'modelable'         => $invoice->modelable
                    ];
                })
        ]);
    }
}
