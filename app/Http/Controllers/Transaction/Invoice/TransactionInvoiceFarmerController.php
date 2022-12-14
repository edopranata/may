<?php

namespace App\Http\Controllers\Transaction\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionInvoiceFarmerController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Farmer/InvoiceFarmerIndex', [
            'farmer'        => $request->farmer,
            'farmers'       => Farmer::query()->with(['loan'])
                ->filter($request->farmer)
                ->whereHas('trades', function (Builder $builder) use ($request){
                    $builder->whereNull('farmer_status')->when($request->date, function (Builder $query, $date){
                        $query->where('trade_date', $date);
                    });
                })
                ->withCount([
                    'trades AS trades_count' => function (Builder $query) use ($request) {
                        $query->select(DB::raw("COUNT(total) as total"))->whereNull('farmer_status')->when($request->date, function (Builder $query, $date){
                            $query->where('trade_date', $date);
                        });
                    }
                ])
                ->withCount([
                    'trades AS trades_total' => function (Builder $query) use ($request) {
                        $query->select(DB::raw("SUM(total) as total"))->whereNull('farmer_status')->when($request->date, function (Builder $query, $date){
                            $query->where('trade_date', $date);
                        });
                    }
                ])->paginate(5)
                ->withQueryString()
                ->through(fn ($farmer) => [
                    'id'            => $farmer->id,
                    'name'          => $farmer->name,
                    'address'       => $farmer->address,
                    'distance'      => $farmer->distance,
                    'phone'         => $farmer->phone,
                    'trades_total'  => $farmer->trades_total,
                    'trades_count'  => $farmer->trades_count,
                    'loan_total'    => $farmer->loan ? $farmer->loan->balance : 0
                ])

        ]);
    }

    public function show(Farmer $farmer)
    {
        return inertia('Transaction/Invoice/Farmer/InvoiceFarmerView', [
            'farmer'    =>  $farmer->load(['loan', 'trades' => function(Builder $builder){
                                $builder->with('trade')->whereNull('farmer_status');
                            }])
        ]);
    }

    public function update(Farmer $farmer, Request $request)
    {
        $farmer->load(['loan']);

        $trades         = collect($request->trades)->pluck('id');

        $total_buy      = collect($request->trades)->sum('total');
        $loan           = $farmer->loan ? $farmer->loan->balance : 0;
        $max            = ($total_buy > $loan) ? $loan : $total_buy;

        $request->validate([
            'invoice_date'  => ['required', 'date', 'before:tomorrow'],
            'installment'   => ['integer', 'min:0', 'max:' . $max ]
        ]);

        DB::beginTransaction();
        try {
            $date           = Carbon::parse($request->invoice_date);
            $sequence       = $this->getLastSequence($request->invoice_date);
            $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

            // Insert into invoices table
            $invoice = $farmer->invoices()->create([
                'sequence' => $sequence,
                'invoice_number' => $invoice_number,
                'invoice_date' => $request->invoice_date,
                'total_buy' => $total_buy,
                'loan' => $loan,
                'loan_installment' => $request->installment,
                'total' => $total_buy - $request->installment,
            ]);

            // Insert into invoice_trade select from trade_details table
            $invoice->trade_details()->attach($trades);

            $invoice->load('trade_details');
            // update farmer_status from trade_details table
            foreach ($invoice->trade_details as $trade_detail) {
                $trade_detail->update([
                    'farmer_status' => $date
                ]);
            }

            // Jika pernah ada pinjaman
            if($farmer->loan){

                // Jika masih ada kewajiban angsuran
                if($farmer->loan->balance > 0){
                    // Insert into loan_details atas pembayaran pinjaman
                    $farmer->loan->details()->create([
                        'invoice_date'      => $request->invoice_date,
                        'description'       => 'Pot Pinjaman Inv #' . $invoice_number,
                        'opening_balance'   => $farmer->loan->balance,
                        'amount'            => $request->installment * -1,
                        'status'            => 'POTONG'
                    ]);

                    // Kurangin sisa pinjaman
                    $farmer->loan()->decrement('balance', $request->installment);
                }
            }
            DB::commit();

            if($request->print){
                return to_route('print.invoice.farmer.show', $invoice->id)->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Invoice petani berhasil disimpan"
                ]);
            }else{
                return redirect()->route('transaction.invoice.farmer.index')->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Invoice petani berhasil disimpan"
                ]);
            }

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Invoice petani gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
