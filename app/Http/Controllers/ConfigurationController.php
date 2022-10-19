<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $config = Configuration::query()->get();
        return inertia('Config/Price/ConfigPriceIndex', [
            'driver'    => $config->where('name', 'driver')->first()->value,
            'loader'    => $config->where('name', 'loader')->first()->value,
            'car'       => $config->where('name', 'car')->first()->value,
        ]);
    }

    public function store(Request $request)
    {

    }
}
