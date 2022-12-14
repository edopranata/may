<?php

namespace App\Http\Controllers\Transaction\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Invoice;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionInvoiceDriverController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Driver/InvoiceDriverIndex', [
            'driver_id' => $request->driver_id,
            'drivers'   => Driver::query()->get()->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'text' => $driver->name . ' (' . $driver->phone . ')'
                ];
            }),
            'trades'    => Trade::query()
                ->whereNotNull('trade_status')
                ->whereNull('driver_status')
                ->when($request->driver_id, function (Builder $builder, $value){
                    $builder->where('driver_id', $value);
                })
                ->with(['driver.price', 'car', 'details'])
                ->orderByDesc('created_at')->paginate(),

        ]);
    }

    public function show(Driver $driver)
    {
        return inertia('Transaction/Invoice/Driver/InvoiceDriverView', [
            'driver'    =>  $driver->load(['price','loan','trades' => function(Builder $builder){
                            $builder->whereNotNull('trade_status')
                                    ->whereNull('driver_status');
                        }])
        ]);
    }

    public function update(Driver $driver, Request $request)
    {
        $driver->load(['loan', 'price']);

        $trades         = collect($request->trades)->pluck('id');
        $total          = $request->total;
        $loan           = $driver->loan ? $driver->loan->balance : 0;
        $max            = ($total > $loan) ? $loan : $total;

        $request->validate([
            'invoice_date'  => ['required', 'date', 'before:tomorrow'],
            'installment'   => ['integer', 'min:0', 'max:' . $max ],
            'driver_fee'    => ['required', 'integer', 'min:1']
        ]);

        DB::beginTransaction();
        try {

            $date           = Carbon::parse($request->invoice_date);
            $sequence       = $this->getLastSequence($request->invoice_date);
            $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

            // Insert into invoices table
            $invoice = $driver->invoices()->create([
                'sequence' => $sequence,
                'invoice_number' => $invoice_number,
                'invoice_date' => $request->invoice_date,
                'total_buy' => $total,
                'loan' => $loan,
                'loan_installment' => $request->installment,
                'total' => $total - $request->installment,
            ]);

            // Insert into invoice_trade select from trade table

            $invoice->trades()->attach($trades);

            $invoice->trades()->update([
                'driver_status' => $date,
                'driver_fee' => $request->driver_fee ?? $driver->price->value
            ]);

            // Jika pernah ada pinjaman
            if($driver->loan){

                // Jika masih ada kewajiban angsuran
                if($driver->loan->balance > 0){

                    // Insert into loan_details atas pembayaran pinjaman
                    $driver->loan->details()->create([
                        'invoice_date'      => $request->invoice_date,
                        'description'       => 'Pot Pinjaman Inv #' . $invoice_number,
                        'opening_balance'   => $driver->loan->balance,
                        'amount'            => $request->installment * -1,
                        'status'            => 'POTONG'
                    ]);

                    // Kurangin sisa pinjaman
                    $driver->loan()->decrement('balance', $request->installment);
                }
            }
            DB::commit();

            if($request->print){
                return to_route('print.invoice.driver.show', $invoice->id)->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Invoice supir berhasil disimpan"
                ]);
            }else{
                return redirect()->route('transaction.invoice.driver.index')->with('alert', [
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

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;
    }
}
