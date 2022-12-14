<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\LoanDetail;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataSupervisorController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Data/Supervisor/SupervisorIndex', [
            'supervisors' => Supervisor::query()->with('price')->when($request->search, function (Builder $builder, $value){
                $builder
                    ->where('name', 'like', '%'.$value.'%')
                    ->orWhere('address', 'like', '%'.$value.'%')
                    ->orWhere('phone', 'like', '%'.$value.'%');

            })->orderByDesc('created_at')->paginate(5)->withQueryString(),
            'price' => 0
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

            $supervisor->price()->create(['value' => $request->price]);

            $supervisor->loan()->create();

            if($request->loan > 0){
                LoanDetail::withoutEvents(function () use ($request, $supervisor){
                    $supervisor->loan->details()->create([
                        'description'       => 'Migrasi Aplikasi (Pinjaman Awal)',
                        'opening_balance'   => $supervisor->loan->balance,
                        'amount'            => $request->loan,
                        'status'            => 'PINJAMAM AWAL'
                    ]);
                });
                $supervisor->loan()->increment('balance', $request->loan);

            }
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
            $supervisor->price()->updateOrCreate(
                ['modelable_id' => $supervisor->id],
                ['value' => $request->price]
            );
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
