<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{

    public function index()
    {
        return inertia('Data/Driver/DriverIndex', [
            'drivers'    => Driver::query()->orderByDesc('created_at')->paginate(5)
        ]);
    }

    public function edit(Driver $driver, Request $request)
    {
        if($request->ajax()){
            return $driver;
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'unique:drivers', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            Driver::query()
                ->create($request->only(['name', 'address', 'phone']));
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

        DB::beginTransaction();
        try {
            $driver->update($request->only(['name', 'address', 'phone']));
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
