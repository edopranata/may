<?php

namespace App\Http\Controllers\Transaction\Loan;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\LoanDetail;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionLoanFarmerController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Transaction/Loan/FarmerLoanIndex', [
            'farmers' => Farmer::query()->filter($request->search)->with('loan')->orderByDesc('created_at')->paginate(5),
        ]);
    }

    public function show($id, Request $request)
    {

        return inertia('Transaction/Loan/FarmerLoan', [
            'farmer'    => Farmer::query()->with('loan')->where('id', $id)->first(),
        ]);

    }

    public function store(Request $request)
    {
        if($request->id){
            $request->validate([
                'date'      => ['required', 'date'],
                'amount'    => ['required', 'integer', 'min:100000']
            ]);

            DB::beginTransaction();
            try {

                $date               = Carbon::parse($request->date);
                $sequence           = $this->getLastSequence($date->format('Y'));
                $invoice_number     = 'MM-P' . $date->format('Y') . sprintf('%06d', $sequence);

                $customer_loan = Farmer::query()->where('id', $request->id)
                    ->with('loan')->first();

                $details = $customer_loan->loan->details()->create([
                    'sequence'          => $sequence,
                    'invoice_number'    => $invoice_number,
                    'invoice_date'      => $date->toDateString(),
                    'description'       => $request->description ?? 'Pinjaman ' . $date->toDateString(),
                    'opening_balance'   => $customer_loan->loan->balance,
                    'amount'            => $request->amount,
                    'status'            => 'PINJAM'
                ]);

                $customer_loan->loan()->increment('balance', $request->amount);

                DB::commit();

                if($request->print){
                    return to_route('print.invoice.loan.show', $details->id)->with('alert', [
                        'type'    => 'success',
                        'title'   => 'Success',
                        'message' => "Pinjaman petani berhasil disimpan"
                    ]);
                }else{
                    return redirect()->route('transaction.loan.farmer.index')->with('alert', [
                        'type'    => 'success',
                        'title'   => 'Success',
                        'message' => "Pinjaman petani berhasil disimpan"
                    ]);
                }


            }catch (\Exception $exception){
                DB::rollBack();
                return redirect()->back()->with('alert', [
                    'type'    => 'error',
                    'title'   => 'Failed',
                    'message' => "Pinjaman petani gagal disimpan: " . $exception->getMessage()
                ]);
            }
        }else{
            abort(404);
        }
    }

    public function edit(Farmer $farmer, Request $request)
    {
        return inertia('Transaction/Loan/FarmerLoanPay', [
            'farmer'    => $farmer->load('loan'),
        ]);
    }

    public function update(Farmer $farmer, Request $request)
    {
        $customer_loan = $farmer->load('loan');
        $max = $customer_loan->loan ? $customer_loan->loan->balance : 0;
        $request->validate([
            'date'      => ['required', 'date'],
            'amount'    => ['required', 'integer', 'min:100000', 'max:' . $max ]
        ]);

        DB::beginTransaction();
        try {
            $date               = Carbon::parse($request->date);
            $sequence           = $this->getLastSequence($date->format('Y'));
            $invoice_number     = 'MM-B' . $date->format('Y') . sprintf('%06d', $sequence);

            $details = $customer_loan->loan->details()->create([
                'sequence'          => $sequence,
                'invoice_number'    => $invoice_number,
                'invoice_date'      => $date->toDateString(),
                'description'       => $request->description ?? 'Angsuran Pinjaman ' . $date->toDateString() ,
                'opening_balance'   => $customer_loan->loan->balance,
                'amount'            => $request->amount * -1,
                'status'            => 'BAYAR'
            ]);

            $customer_loan->loan()->decrement('balance', $request->amount);

            DB::commit();
            if($request->print){
                return to_route('print.invoice.loan.show', $details->id)->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Pinjaman petani berhasil disimpan"
                ]);
            }else{
                return redirect()->route('transaction.loan.farmer.index')->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Pinjaman petani berhasil disimpan"
                ]);
            }


        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Pinjaman petani gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    private function getLastSequence($year = null) {
        $invoice = LoanDetail::query()->whereYear('invoice_date', $year ?? now()->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
