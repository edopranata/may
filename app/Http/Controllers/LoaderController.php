<?php

namespace App\Http\Controllers;

use App\Models\Loader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoaderController extends Controller
{
    public function index()
    {
        return inertia('Data/Loader/LoaderIndex', [
            'loaders'    => Loader::query()->orderByDesc('created_at')->paginate(5)
        ]);
    }

    public function edit(Loader $loader, Request $request)
    {
        if($request->ajax()){
            return $loader;
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'unique:loaders', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            Loader::query()
                ->create($request->only(['name', 'address', 'phone']));
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data tukang muat disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data tukang muat gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function update(Loader $loader, Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:loaders,name,' . $loader->id],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            $loader->update($request->only(['name', 'address', 'phone']));
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'info',
                'title'   => 'Success',
                'message' => "Data tukang muat berhasil diubah"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data tukang muat gagal diubah: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(Loader $loader)
    {
        DB::beginTransaction();
        try {
            $loader->delete();
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'warn',
                'title'   => 'Success',
                'message' => "Data tukang muat berhasil dihapus"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data tukang muat gagal dihapus"
            ]);
        }
    }
}
