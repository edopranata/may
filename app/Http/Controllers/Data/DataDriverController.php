<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Driver;
use App\Models\LoanDetail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataDriverController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Data/Driver/DriverIndex', [
            'drivers'    => Driver::query()->when($request->search, function (Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('address', 'like', '%'.$value.'%')
                    ->orWhere('phone', 'like', '%'.$value.'%');

            })->with(['loan', 'price'])->paginate(5)->withQueryString(),
            'price'      => Configuration::query()->where('name', 'driver')->first()->value,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'unique:drivers', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            $driver = Driver::query()
                ->create($request->only(['name', 'address', 'phone']));

            $driver->price()->create(['value' => $request->price]);

            $driver->loan()->create();

            if($request->loan > 0){
                LoanDetail::withoutEvents(function () use ($request, $driver){
                    $driver->loan->details()->create([
                        'description'       => 'Migrasi Aplikasi (Pinjaman Awal)',
                        'opening_balance'   => $driver->loan->balance,
                        'amount'            => $request->loan,
                        'status'            => 'PINJAMAM AWAL'
                    ]);
                });
                $driver->loan()->increment('balance', $request->loan);

            }
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data supir disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data supir gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function update(Driver $driver, Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:drivers,name,' . $driver->id],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        $driver->load('price');

        DB::beginTransaction();
        try {
            $driver->update($request->only(['name', 'address', 'phone']));
            $driver->price()->updateOrCreate(
                ['modelable_id' => $driver->id],
                ['value' => $request->price]
            );
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'info',
                'title'   => 'Success',
                'message' => "Data supir berhasil diubah"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data supir gagal diubah: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(Driver $driver)
    {
        DB::beginTransaction();
        try {
            $driver->delete();
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'warn',
                'title'   => 'Success',
                'message' => "Data supir berhasil dihapus"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data supir gagal dihapus"
            ]);
        }
    }
}
