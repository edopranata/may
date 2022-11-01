<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Supervisor;
use App\Models\Trade;
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
                    'id' => $supervisor->id,
                    'text' => $supervisor->name . ' (' . $supervisor->phone . ')'
                ];
            }),
            'trades'    => Trade::query()
                ->whereNotNull('trade_status')
                ->whereNull('supervisor_status')
                ->when($request->supervisor_id, function (Builder $builder, $value){
                    $builder->where('supervisor_id', $value);
                })
                ->with(['supervisor.price', 'car', 'details'])
                ->orderByDesc('created_at')->paginate(),

        ]);
    }

    public function show(Supervisor $supervisor)
    {
        return inertia('Transaction/Invoice/Supervisor/InvoiceSupervisorView', [
            'supervisor'    =>  $supervisor->load(['price','loan','trades' => function(Builder $builder){
                $builder->whereNotNull('trade_status')
                    ->whereNull('supervisor_status');
            }])
        ]);
    }

    public function update(Supervisor $supervisor, Request $request)
    {
        $supervisor->load(['loan', 'price']);

//        $trades         = collect($request->trades)->pluck('id');
        $total          = $request->total;
        $loan           = $supervisor->loan ? $supervisor->loan->balance : 0;
        $max            = ($total > $loan) ? $loan : $total;

        $request->validate([
            'invoice_date'  => ['required', 'date', 'before:tomorrow'],
            'installment'   => ['integer', 'min:0', 'max:' . $max ],
            'supervisor_fee'    => ['required', 'integer', 'min:1']
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
                'total_buy' => $total,
                'loan' => $loan,
                'loan_installment' => $request->installment,
                'total' => $total - $request->installment,
            ]);

            // Insert into invoice_trade select from trade table

//            $invoice->trades()->attach($trades);
//
//            $invoice->trades()->update([
//                'supervisor_status' => now()->toDateTimeString(),
//                'supervisor_fee' => $request->supervisor_fee ?? $supervisor->price->value
//            ]);

            // Jika pernah ada pinjaman
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
                    'message' => "Invoice supir berhasil disimpan"
                ]);
            }else{
                return redirect()->route('transaction.invoice.supervisor.index')->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Invoice supir berhasil disimpan"
                ]);
            }

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Invoice supir gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    private function getLastSequence() {
        $invoice = Invoice::query()->whereYear('invoice_date', now()->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
