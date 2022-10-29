<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function index()
    {
        return inertia('Config/ConfigIndex');
    }
}
