<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Data/Supervisor/SupervisorIndex', [
            'supervisors' => Supervisor::query()->when($request->search, function (Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('address', 'like', '%'.$value.'%')
                    ->orWhere('phone', 'like', '%'.$value.'%');

            })->orderByDesc('created_at')->paginate(5)->withQueryString(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'unique:supervisors', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            $supervisor = Supervisor::query()
                ->create($request->only(['name', 'address', 'phone']));

            $supervisor->loan()->create();

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data mandor disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data mandor gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function update(Supervisor $supervisor, Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:supervisors,name,' . $supervisor->id],
            'phone'  => ['required', 'string', 'max:255']
        ]);

        DB::beginTransaction();
        try {
            $supervisor->update($request->only(['name', 'address', 'phone']));

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'info',
                'title'   => 'Success',
                'message' => "Data mandor berhasil diubah"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data mandor gagal diubah: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(Supervisor $supervisor)
    {
        DB::beginTransaction();
        try {
            $supervisor->delete();
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'warn',
                'title'   => 'Success',
                'message' => "Data mandor berhasil dihapus"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data mandor gagal dihapus"
            ]);
        }
    }
}
