<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Loader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoaderController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Data/Loader/LoaderIndex', [
            'loaders' => Loader::query()->when($request->search, function (Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('address', 'like', '%'.$value.'%')
                    ->orWhere('phone', 'like', '%'.$value.'%');

            })->with('price')->orderByDesc('created_at')->paginate(5)->withQueryString(),
            'price'   => Configuration::query()->where('name', 'loader')->first()->value
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'unique:loaders', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            $loader = Loader::query()
                ->create($request->only(['name', 'address', 'phone']));

            $loader->price()->create(['value' => $request->price]);

            $loader->loan()->create();

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
            $loader->price()->updateOrCreate(
                ['modelable_id' => $loader->id],
                ['value' => $request->price]
            );
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
