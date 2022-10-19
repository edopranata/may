<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function index()
    {
        return inertia('Data/Car/CarIndex', [
            'cars'    => Car::query()->with('price')->orderByDesc('created_at')->paginate(5),
            'price'   => 0
        ]);
    }

    public function edit(Car $car, Request $request)
    {
        if($request->ajax()){
            return $car->load('price');
        }
        abort(404);
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

            $car->price()->create(['value' => $request->price]);
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
            $car->price()->updateOrCreate(['value' => $request->price]);
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
