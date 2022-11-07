<?php

namespace App\Http\Controllers\Transaction\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionInvoiceSupervisorController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Supervisor/InvoiceSupervisorIndex', [
            'supervisor_id' => $request->supervisor_id,
            'supervisors'   => Supervisor::query()->get()->map(function ($supervisor) {
                return [
                    'value' => $supervisor->id,
                    'label' => $supervisor->name . ' (' . $supervisor->phone . ')'
                ];
            }),
            'date'          => $request->date,
            'invoices'      => Invoice::query()->whereHasMorph('modelable', [Supervisor::class], function (Builder $builder) use ($request) {
                $builder->when($request->supervisor_id, function (Builder $supervisor, $id){
                        $supervisor->where('id', $id);
                    });
                })
                ->orderByDesc('created_at')->paginate()->through( function ($invoice) {
                    return [
                        'id'                => $invoice->id,
                        'invoice_number'    => $invoice->invoice_number,
                        'invoice_date'      => $invoice->invoice_date->format('d F Y'),
                        'total_buy'         => $invoice->total_buy,
                        'loan'              => $invoice->loan,
                        'loan_installment'  => $invoice->loan_installment,
                        'total'             => $invoice->total,
                        'modelable'         => $invoice->modelable
                    ];
                }),

        ]);
    }

    public function show(Supervisor $supervisor, Request $request)
    {
        return inertia('Transaction/Invoice/Supervisor/InvoiceSupervisorView', [
            'supervisor'    => $supervisor->load(['price', 'loan']),
            'invoices'      => Invoice::query()->whereHasMorph('modelable', [Supervisor::class], function (Builder $builder) use ($supervisor) {
                    $builder->where('id', $supervisor->id);
                })
                ->orderByDesc('created_at')->paginate()->through( function ($invoice) {
                    return [
                        'id'                => $invoice->id,
                        'invoice_number'    => $invoice->invoice_number,
                        'invoice_date'      => $invoice->invoice_date->format('d F Y'),
                        'total_buy'         => $invoice->total_buy,
                        'loan'              => $invoice->loan,
                        'loan_installment'  => $invoice->loan_installment,
                        'total'             => $invoice->total,
                        'modelable'         => $invoice->modelable
                    ];
                }),
        ]);
    }

    public function update(Supervisor $supervisor, Request $request)
    {
        $supervisor->load(['price', 'loan']);

        $total          = $request->total;
        $loan           = $supervisor->loan ? $supervisor->loan->balance : 0;
        $max            = ($total > $loan) ? $loan : $total;

        $request->validate([
            'invoice_date'      => ['required', 'date', 'before:tomorrow',
                function ($attribute, $value, $fail) use ($request, $supervisor) {
                    $date = Carbon::parse($value);
                    $spv = Invoice::query()->whereHasMorph('modelable', [Supervisor::class], function (Builder $builder) use ($request, $supervisor) {
                        $supervisor->where('id', $supervisor->id);
                    })->whereMonth('invoice_date', $date->format('m'))->whereYear('invoice_date', $date->format('Y'))->first();
                    if ($spv) {
                        $fail('In this month '.$spv->invoice_date->format('m') . '-' . $spv->invoice_date->format('Y').' has been paid');
                    }
            },],
            'supervisor_fee'    => ['required', 'integer', 'min:1'],
            'installment'       => ['integer', 'min:0', 'max:' . $max ]
        ]);

        DB::beginTransaction();
        try {

            $sequence       = $this->getLastSequence();
            $invoice_number = 'MM' . now()->format('Y') . sprintf('%08d', $sequence);

            // Insert into invoices table
            $invoice = $supervisor->invoices()->create([
                'sequence' => $sequence,
                'invoice_number' => $invoice_number,
                'invoice_date' => $request->invoice_date,
                'loan' => $loan,
                'loan_installment' => $request->installment,
                'total_buy' => $total,
                'total' => $total,
            ]);

            if($supervisor->loan){

                // Jika masih ada kewajiban angsuran
                if($supervisor->loan->balance > 0){
                    // Kurangin sisa pinjaman
                    $supervisor->loan()->decrement('balance', $request->installment);

                    // Insert into loan_details atas pembayaran pinjaman
                    $supervisor->loan->details()->create([
                        'description' => 'Pot Pinjaman Inv #' . $invoice_number,
                        'amount' => $request->installment * -1,
                        'status' => 'POTONG'
                    ]);
                }
            }
            DB::commit();

            if($request->print){
                return to_route('print.invoice.supervisor.show', $invoice->id)->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Amprah mobil berhasil disimpan"
                ]);
            }else{
                return redirect()->route('transaction.invoice.supervisor.index')->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Amprah mobil berhasil disimpan"
                ]);
            }

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Amprah mobil gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    private function getLastSequence() {
        $invoice = Invoice::query()->whereYear('invoice_date', now()->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
