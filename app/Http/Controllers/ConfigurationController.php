<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    public function index()
    {
        $config = Configuration::query()->get();
        return inertia('Config/Price/ConfigPriceIndex', [
            'driver'    => collect($config)->where('name', 'driver')->first()->value,
            'loader'    => collect($config)->where('name', 'loader')->first()->value,
            'car'       => collect($config)->where('name', 'car')->first()->value,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Configuration::query()
                ->updateOrCreate(['name' => $request->name], ['value' => $request->value]);
            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Pengaturan harga default disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Pengaturan harga default gagal disimpan: " . $exception->getMessage()
            ]);
        }

    }
}
