<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;

class DataController extends Controller
{

    public function index()
    {
        return inertia('Data/DataIndex');
    }
}
