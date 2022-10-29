<?php

namespace App\Http\Controllers\Prints;

use App\Http\Controllers\Controller;

class PrintController extends Controller
{

    public function index()
    {
        return to_route('dashboard.index');
    }
}
