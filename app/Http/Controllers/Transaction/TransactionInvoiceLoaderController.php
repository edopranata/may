<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Invoice;
use App\Models\Loader;
use App\Models\Trade;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionInvoiceLoaderController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Loader/InvoiceLoaderIndex', [
            'price'     => Configuration::query()->where('name', 'loader')->first()->value,
            'dates'     => [
                'start' => $request->start_date,
                'end'   => $request->end_date,
            ],
            'trades'    => Trade::query()
                ->whereNotNull('trade_status')
                ->whereNull('loader_status')
                ->when($request->start_date, function (Builder $builder, $value){
                    $builder->whereDate('trade_date', '>=', $value);
                })
                ->when($request->end_date, function (Builder $builder, $value){
                    $builder->whereDate('trade_date', '<=', $value);
                })
                ->with(['driver', 'car', 'details'])
                ->orderByDesc('created_at')->paginate(),

        ]);
    }

    public function show(Loader $loader)
    {
        return inertia('Transaction/Invoice/Loader/InvoiceLoaderView', [
            'loader'    =>  $loader->load(['price','trades' => function(Builder $builder){
                $builder->whereNotNull('trade_status')
                    ->whereNull('loader_status');
            }])
        ]);
    }

    public function update(Loader $loader, Request $request)
    {
        $loader->load(['price']);

        $trades         = collect($request->trades)->pluck('id');
        $total          = $request->total;
        $max            = $total;

        $request->validate([
            'invoice_date'  => ['required', 'date', 'before:tomorrow'],
            'loader_fee'       => ['required', 'integer', 'min:1']
        ]);

        DB::beginTransaction();
        try {

            $sequence       = $this->getLastSequence();
            $invoice_number = 'MM' . now()->format('Y') . sprintf('%08d', $sequence);

            // Insert into invoices table
            $invoice = $loader->invoices()->create([
                'sequence' => $sequence,
                'invoice_number' => $invoice_number,
                'invoice_date' => $request->invoice_date,
                'total_buy' => $total,
                'total' => $total - $request->installment,
            ]);

            // Insert into invoice_trade select from trade table

            $invoice->trades()->attach($trades);

            $invoice->trades()->update([
                'loader_status' => $request->invoice_date,
                'loader_fee'    => $request->loader_fee ?? $loader->price->value
            ]);

            DB::commit();

            if($request->print){
                return to_route('print.invoice.loader.show', $invoice->id)->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Amprah mobil berhasil disimpan"
                ]);
            }else{
                return redirect()->route('transaction.invoice.loader.index')->with('alert', [
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
