<?php

namespace App\Http\Controllers\Transaction\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Invoice;
use App\Models\Loader;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionInvoiceLoaderController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Invoice/Loader/InvoiceLoaderIndex', [
            'loader_id' => Loader::query()->first()->id,
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

    public function show(Loader $loader, Request $request)
    {

        return inertia('Transaction/Invoice/Loader/InvoiceLoaderView', [
            'dates'     => [
                'start' => $request->start,
                'end'   => $request->end,
            ],
            'loader'    =>  $loader->load(['price']),
            'trades'    => Trade::query()
                ->whereNotNull('trade_status')
                ->whereNull('loader_status')
                ->when($request->start, function (Builder $builder, $value){
                    $builder->whereDate('trade_date', '>=', $value);
                })
                ->when($request->end, function (Builder $builder, $value){
                    $builder->whereDate('trade_date', '<=', $value);
                })
                ->with(['driver', 'car', 'details'])->get()
        ]);
    }

    public function update(Loader $loader, Request $request)
    {
        $loader->load(['price']);

        $trades         = collect($request->trades)->pluck('id');
        $total          = $request->total;


        $request->validate([
            'invoice_date'      => ['required', 'date', 'before:tomorrow'],
            'loader_fee'       => ['required', 'integer', 'min:1']
        ]);

        DB::beginTransaction();
        try {

            $date           = Carbon::parse($request->invoice_date);
            $sequence       = $this->getLastSequence($request->invoice_date);
            $invoice_number = 'MM' . $date->format('Y') . sprintf('%08d', $sequence);

            // Insert into invoices table
            $invoice = $loader->invoices()->create([
                'sequence' => $sequence,
                'invoice_number' => $invoice_number,
                'invoice_date' => $request->invoice_date,
                'total_buy' => $total,
                'total' => $total,
            ]);

            // Insert into invoice_trade select from trade table

            $invoice->trades()->attach($trades);

            $invoice->trades()->update([
                'loader_status' => $date,
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

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Invoice::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
