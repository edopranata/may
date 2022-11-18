<?php

namespace App\Http\Controllers\Prints\Loan;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class PrintLoanController extends Controller
{
    private function getType($modelable_type, $id)
    {
        $model = collect(explode('\\', $modelable_type))->last();

        switch ($model){
            case "Farmer":
                return [
                    'name'          => 'farmer',
                    'title'         => 'Pinjaman Petani',
                ];
            case "Driver":
                return [
                    'name'          => 'driver',
                    'title'         => 'Pinjaman Supir',
                ];
            case "Supervisor":
                return [
                    'name'          => 'supervisor',
                    'title'         => 'Pinjaman Mandor',
                ];
                break;
            default:
                return $model;
        }
    }

    public function index(Request $request)
    {
//        dd(Loan::query()->with(['modelable'])->where('balance', '>', 0)->get()->toArray());
        return inertia('Print/Loan/PrintLoan', [
            'date'   => now()->format('d F Y'),
            'loans'  => Loan::query()->with(['modelable'])->where('balance', '>', 0)->get()->map(function ($loan){
                return [
                    'id'         => $loan->id,
                    'type'       => $this->getType($loan->modelable_type, $loan->id),
                    'total'      => $loan->balance,
                    'modelable'  => $loan->modelable
                ];
            }),
        ]);
    }
}
