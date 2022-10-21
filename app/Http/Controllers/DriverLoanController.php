<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverLoanController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Loan/DriverLoanIndex', [
            'drivers' => Driver::query()->when($request->search, function (Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('address', 'like', '%'.$value.'%')
                    ->orWhere('phone', 'like', '%'.$value.'%');
            })->with('loan')->orderByDesc('created_at')->paginate(5),
        ]);
    }

    public function show($id, Request $request)
    {

        return inertia('Transaction/Loan/DriverLoan', [
            'driver'    => Driver::query()->with('loan')->where('id', $id)->first(),
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
                $customer_loan = Driver::query()->where('id', $request->id)
                    ->with('loan')->first();

                $loan = $customer_loan->loan()->increment('balance', $request->amount);

                $customer_loan->loan->details()->create([
                    'description' => $request->description ?? 'Pinjaman ' . now()->format('d F Y'),
                    'amount' => $request->amount,
                    'status' => 'PINJAM'
                ]);
                DB::commit();
                return redirect()->route('transaction.loan.driver.index')->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Pinjaman supir berhasil disimpan"
                ]);

            }catch (\Exception $exception){
                DB::rollBack();
                return redirect()->back()->with('alert', [
                    'type'    => 'error',
                    'title'   => 'Failed',
                    'message' => "Pinjaman supir gagal disimpan: " . $exception->getMessage()
                ]);
            }
        }else{
            abort(404);
        }
    }

    public function edit(Driver $driver, Request $request)
    {
        return inertia('Transaction/Loan/DriverLoanPay', [
            'driver'    => $driver->load('loan'),
        ]);
    }

    public function update(Driver $driver, Request $request)
    {
        $customer_loan = $driver->load('loan');
        $max = $customer_loan->loan ? $customer_loan->loan->balance : 0;
        $request->validate([
            'date'      => ['required', 'date'],
            'amount'    => ['required', 'integer', 'min:100000', 'max:' . $max ]
        ]);

        DB::beginTransaction();
        try {

            $loan = $customer_loan->loan()->decrement('balance', $request->amount);

            $customer_loan->loan->details()->create([
                'description' => $request->description ?? 'Angsuran Pinjaman ' . now()->format('d F Y'),
                'amount' => $request->amount * -1,
                'status' => 'BAYAR'
            ]);
            DB::commit();
            return redirect()->route('transaction.loan.driver.index')->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Pinjaman supir berhasil disimpan"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Pinjaman supir gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }
}
