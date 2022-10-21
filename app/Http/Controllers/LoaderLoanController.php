<?php

namespace App\Http\Controllers;

use App\Models\Loader;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoaderLoanController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Transaction/Loan/LoaderLoanIndex', [
            'loaders' => Loader::query()->when($request->search, function (Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('address', 'like', '%'.$value.'%')
                    ->orWhere('phone', 'like', '%'.$value.'%');
            })->with('loan')->orderByDesc('created_at')->paginate(5),
        ]);
    }

    public function show($id, Request $request)
    {

        return inertia('Transaction/Loan/LoaderLoan', [
            'loader'    => Loader::query()->with('loan')->where('id', $id)->first(),
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
                $customer_loan = Loader::query()->where('id', $request->id)
                    ->with('loan')->first();

                $loan = $customer_loan->loan()->increment('balance', $request->amount);

                $customer_loan->loan->details()->create([
                    'description' => $request->description ?? 'Pinjaman ' . now()->format('d F Y'),
                    'amount' => $request->amount,
                    'status' => 'PINJAM'
                ]);
                DB::commit();
                return redirect()->route('transaction.loan.loader.index')->with('alert', [
                    'type'    => 'success',
                    'title'   => 'Success',
                    'message' => "Pinjaman tukang muat berhasil disimpan"
                ]);

            }catch (\Exception $exception){
                DB::rollBack();
                return redirect()->back()->with('alert', [
                    'type'    => 'error',
                    'title'   => 'Failed',
                    'message' => "Pinjaman tukang muat gagal disimpan: " . $exception->getMessage()
                ]);
            }
        }else{
            abort(404);
        }
    }

    public function edit(Loader $loader, Request $request)
    {
        return inertia('Transaction/Loan/LoaderLoanPay', [
            'loader'    => $loader->load('loan'),
        ]);
    }

    public function update(Loader $loader, Request $request)
    {
        $customer_loan = $loader->load('loan');
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
            return redirect()->route('transaction.loan.loader.index')->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Pinjaman tukang muat berhasil disimpan"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Pinjaman tukang muat gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }
}
