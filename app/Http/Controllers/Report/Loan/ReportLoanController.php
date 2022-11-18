<?php

namespace App\Http\Controllers\Report\Loan;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Farmer;
use App\Models\Loan;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportLoanController extends Controller
{

    public function index()
    {
        return inertia('Report/Loan/ReportLoanIndex');
    }
    private function getType($modelable_type, $id)
    {
        $model = collect(explode('\\', $modelable_type))->last();

        switch ($model){
            case "Farmer":
                return 'Petani';
            case "Driver":
                return 'Supir';
            case "Car":
                return 'Karyawan';
            break;
            default:
                return $model;
        }
    }

    public function details(Request $request)
    {

        return inertia('Report/Loan/ReportLoanDetails', [

            'loans'     => Loan::query()->where('balance', '>', 0)->whereHasMorph(
                'modelable', [Farmer::class, Driver::class, Supervisor::class])->get()->map(function ($loan) {
                return [
                    'value' => $loan->id,
                    'label' => $loan->modelable->name . ' (' . $this->getType($loan->modelable_type, $loan->id) . ')'
                ];
            }),
            'loan_id'   => $request->loan_id,
            'details'   => $request->loan_id ? Loan::query()->where('balance', '>', 0)->with(['details'])->first() : []
        ]);
    }

    public function all(Request $request)
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
