<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataFarmerController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Data/Farmer/FarmerIndex', [
            'farmers'   => Farmer::query()->filter($request->search)->paginate()->withQueryString(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'unique:farmers', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            $farmer = Farmer::query()
                ->create($request->only(['name', 'address', 'phone', 'distance']));

            $farmer->loan()->create();
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data petani disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data petani gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function update(Farmer $farmer, Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:farmers,name,' . $farmer->id],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            $farmer->update($request->only(['name', 'address', 'phone', 'distance']));
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'info',
                'title'   => 'Success',
                'message' => "Data petani berhasil diubah"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data petani gagal diubah: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(Farmer $farmer)
    {
        DB::beginTransaction();
        try {
            $farmer->delete();
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'warn',
                'title'   => 'Success',
                'message' => "Data petani berhasil dihapus"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data petani gagal dihapus"
            ]);
        }
    }
}
