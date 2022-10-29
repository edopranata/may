<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Configuration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataCarController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Data/Car/CarIndex', [
            'cars'    => Car::query()->when($request->search, function (Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('no_pol', 'like', '%'.$value.'%')
                    ->orWhere('description', 'like', '%'.$value.'%');

            })->orderByDesc('created_at')->paginate(5)->withQueryString(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'no_pol'  => ['required', 'string', 'max:12']
        ]);

        DB::beginTransaction();
        try {
            $car = Car::query()
                ->create($request->only(['name', 'description', 'year', 'no_pol']));

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data mobil disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data mobil gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function update(Car $car, Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'no_pol'  => ['required', 'string', 'max:12']
        ]);

        DB::beginTransaction();
        try {
            $car->update($request->only(['name', 'description', 'year', 'no_pol']));

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'info',
                'title'   => 'Success',
                'message' => "Data mobil berhasil diubah"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data mobil gagal diubah: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(Car $car)
    {
        DB::beginTransaction();
        try {
            $car->delete();
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'warn',
                'title'   => 'Success',
                'message' => "Data mobil berhasil dihapus"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data mobil gagal dihapus"
            ]);
        }
    }
}
