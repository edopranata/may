<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Invoice;
use App\Models\Trade;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionInvoiceCarController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Car/InvoiceCarIndex', [
            'car_id' => $request->car_id,
            'cars'   => Car::query()->get()->map(function ($car) {
                return [
                    'id' => $car->id,
                    'text' => $car->no_pol . ' (' . $car->name . ')'
                ];
            }),
            'trades'    => Trade::query()
                ->whereNotNull('trade_status')
                ->whereNull('car_status')
                ->when($request->car_id, function (Builder $builder, $value){
                    $builder->where('car_id', $value);
                })
                ->with(['car.price', 'driver', 'details'])
                ->orderByDesc('created_at')->paginate(),

        ]);
    }

    public function show(Car $car)
    {
        return inertia('Transaction/Invoice/Car/InvoiceCarView', [
            'car'    =>  $car->load(['price','trades' => function(Builder $builder){
                $builder->whereNotNull('trade_status')
                    ->whereNull('car_status');
            }])
        ]);
    }

    public function update(Car $car, Request $request)
    {
        $car->load(['loan', 'price']);

        $trades         = collect($request->trades)->pluck('id');
        $total          = $request->total;
        $loan           = $car->loan ? $car->loan->balance : 0;
        $max            = ($total > $loan) ? $loan : $total;

        $request->validate([
            'invoice_date'  => ['required', 'date', 'before:tomorrow'],
            'installment'   => ['integer', 'min:0', 'max:' . $max ],
            'car_fee'    => ['required', 'integer', 'min:1']
        ]);

        DB::beginTransaction();
        try {

            $sequence       = $this->getLastSequence();
            $invoice_number = 'MM' . now()->format('Y') . sprintf('%08d', $sequence);

            // Insert into invoices table
            $invoice = $car->invoices()->create([
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
                'car_status' => now()->toDateTimeString(),
                'car_fee' => $request->car_fee ?? $car->price->value
            ]);

            // Jika pernah ada pinjaman
            if($car->loan){

                // Jika masih ada kewajiban angsuran
                if($car->loan->balance > 0){
                    // Kurangin sisa pinjaman
                    $car->loan()->decrement('balance', $request->installment);

                    // Insert into loan_details atas pembayaran pinjaman
                    $car->loan->details()->create([
                        'description' => 'Pot Pinjaman Inv #' . $invoice_number,
                        'amount' => $request->installment * -1,
                        'status' => 'POTONG'
                    ]);
                }
            }
            DB::commit();

            if($request->print){
                return to_route('print.invoice.car.show', $invoice->id)->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Invoice supir berhasil disimpan"
                ]);
            }else{
                return redirect()->route('transaction.invoice.car.index')->with('alert', [
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
