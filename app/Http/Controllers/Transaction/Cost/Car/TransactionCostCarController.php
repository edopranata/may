<?php

namespace App\Http\Controllers\Transaction\Cost\Car;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Cost;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionCostCarController extends Controller
{

    public function index(Request $request)
    {

        return inertia('Transaction/Cost/Car/CostCarIndex', [
            'categories'    => Configuration::query()->where('name', 'cost')->get()->map(function ($cost){
                return [
                    'value' => $cost->text,
                    'label' => $cost->text
                ];
            }),
            'cars' => Car::query()->get()->map(function ($driver){
                return [
                    'value' => $driver->id,
                    'label' => $driver->no_pol . ' (' . $driver->name . ')'
                ];
            }),
            'costs' => Cost::query()->with(['car'])->paginate()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_date'      => ['required', 'date', 'before:tomorrow'],
            'name'              => ['required', Rule::exists('configurations', 'text')->where('name', 'cost')],
            'car_id'            => ['required', 'exists:cars,id'],

            'amount'            => ['required', 'integer', 'min:1']
        ]);

        DB::beginTransaction();
        try {
            $date           = Carbon::parse($request->invoice_date);
            $sequence       = $this->getLastSequence($request->invoice_date);
            $invoice_number = 'MMO-' . now()->format('Y') . sprintf('%06d', $sequence);

            Cost::query()
                ->create([
                    'car_id'            => $request->car_id,
                    'invoice_date'      => $request->invoice_date,
                    'sequence'          => $sequence,
                    'invoice_number'    => $invoice_number,
                    'name'              => $request->name,
                    'description'       => $request->desctription,
                    'amount'            => $request->amount,
                ]);

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Biaya operasional berhasil disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Biaya oprasional gagal disimpan: " . $exception->getMessage()
            ]);
        }

    }

    private function getLastSequence($invoice_date) {
        $date = Carbon::parse($invoice_date);
        $invoice = Cost::query()->whereYear('invoice_date', $date->format('Y'))->latest()->first();
        return $invoice ? ($invoice->sequence + 1) : 1;

    }
}
