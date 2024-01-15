<?php

namespace App\Http\Controllers\Transaction\Trade;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Invoice;
use App\Models\InvoiceTrade;
use App\Models\Trade;
use App\Models\TradeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionTradeController extends Controller
{
    public function index()
    {
        return inertia('Transaction/Trade/TradeIndex', [
            'trades' => Trade::query()->with(['driver', 'car', 'details'])->orderByDesc('created_at')->paginate(),
            'drivers' => Driver::query()->get()->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'text' => $driver->name . ' (' . $driver->phone . ')'
                ];
            }),
            'cars' => Car::query()->get()->map(function ($car) {
                return [
                    'id' => $car->id,
                    'text' => $car->no_pol . ' - ' . $car->name
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'car_id' => ['required', 'exists:cars,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'trade_cost' => ['required', 'numeric', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $trade = Trade::query()
                ->create([
                    'driver_id' => $request->driver_id,
                    'car_id' => $request->car_id,
                    'trade_date' => $request->date,
                    'trade_cost' => $request->trade_cost
                ]);
            DB::commit();
            return redirect()->route('transaction.trade.edit', $trade->id)->with('alert', [
                'type' => 'success',
                'title' => 'Success',
                'message' => "Data transaksi berhasil disimpan"
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => "Data transaksi gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function edit(Trade $trade)
    {
        return inertia('Transaction/Trade/TradeCreate', [
            'trade' => $trade->load(['driver', 'car', 'details.farmer', 'details.invoice_trade']),
            'farmers' => Farmer::query()->get()->map(function ($farmer) {
                return [
                    'value' => $farmer->id,
                    'label' => $farmer->name . ' (' . $farmer->phone . ')'
                ];
            }),
        ]);
    }

    public function trade_edit(TradeDetail $trade)
    {
        return inertia('Transaction/Trade/TradeFarmerEdit', [
            'trade' => $trade->load(['farmer', 'trade'])
        ]);
    }

    public function trade_update(TradeDetail $trade, Request $request)
    {
        $request->validate([
            'weight' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $trade->withoutEvents(function () use ($trade, $request) {
                $trade->updateQuietly([
                    'weight' => $request->weight,
                    'price' => $request->price,
                    'total' => $request->total,
                ]);

                $trade->load(['trade.details']);

                // Ubah data trade details
                $trade->trade()->update([
                    'gross_weight' => $trade->trade->details()->sum('weight'),
                    'gross_total' => $trade->trade->details()->sum('total'),
                    'gross_price' => $trade->trade->details()->avg('price')
                ]);

                $trade->load(['invoice_trade.invoice.trade_details', 'invoice_trade.invoice.expense']);

                if ($trade->farmer_status !== null) {
                    // JIka invoice telah terbit
                    // 1. Ubah data invoice
                    // 2. Ubah data expense
                    if ($trade->invoice_trade->invoice_id !== null) {
                        Invoice::withoutEvents(function () use ($trade) {
                            // Update data invoice
                            $invoice = Invoice::query()
                                ->with('trade_details')
                                ->where('id', $trade->invoice_trade->invoice_id)->first();

                            $installment = $trade->invoice_trade->invoice->loan_installment;
                            $sum_total = $invoice->trade_details->sum('total');
//                            dd($sum_total);
                            $invoice->update([
                                'total_buy' => $sum_total,
                                'total' => $sum_total - $installment
                            ]);

                            // Ubah data Expense
                            $expense_detail = $trade->invoice_trade->invoice->expense();

                            $expense_detail->update([
                                'amount' => $invoice->total
                            ]);

                            $expense = $expense_detail->first()->expense()->first();
                            $expense->load('details');
                            $expense->update([
                                'balance'   => $expense->details->sum('amount')
                            ]);
                        });


                    }
                }

                DB::commit();

            });

            return redirect()->route('transaction.trade.edit', $trade->trade_id)->with('alert', [
                'type' => 'success',
                'title' => 'Success',
                'message' => "Data transaksi berhasil diupdate"
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => "Data transaksi gagal diupdate: " . $exception->getMessage()
            ]);
        }
    }

    public function update(Trade $trade, Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'farmer_id' => ['required', 'exists:farmers,id'],
            'weight' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {

            $trade->details()
                ->create([
                    'trade_date' => $request->date,
                    'farmer_id' => $request->farmer_id,
                    'weight' => $request->weight,
                    'price' => $request->price,
                    'total' => $request->total,
                ]);

            $trade->withoutEvents(function () use ($trade, $request) {
                $trade->increment('gross_weight', $request->weight);
                $trade->increment('gross_total', $request->total);

                $trade->update(['gross_price' => $trade->details()->avg('price')]);
            });

            DB::commit();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Success',
                'message' => "Data transaksi berhasil disimpan"
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => "Data transaksi gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(TradeDetail $trade, Request $request)
    {

        if ($trade->farmer_status) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => "Data transaksi gagal dihapus karena invoice telah terbit atau telah dibayarkan"
            ]);
        }

        DB::beginTransaction();
        try {
            $decrement = Trade::query()
                ->where('id', $trade->trade_id);

            $decrement->decrement('gross_weight', $trade->weight);
            $decrement->decrement('gross_price', $trade->price);
            $decrement->decrement('gross_total', $trade->total);

            $trade->delete();

            DB::commit();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Success',
                'message' => "Data transaksi berhasil disimpan"
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => "Data transaksi gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function deleted(Trade $trade)
    {
        DB::beginTransaction();
        try {

            if ($trade->details()->count() > 0) {
                throw new \Exception('Transaction details is not empty', '401');
            }
            $trade->delete();

            DB::commit();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Success',
                'message' => "Data transaksi berhasil dihapus"
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => "Data transaksi gagal dihapus: " . $exception->getMessage()
            ]);
        }
    }
}
