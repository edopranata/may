<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function data()
    {
        return inertia('Data/DataIndex');
    }

    public function transaction()
    {
        return inertia('Transaction/TransactionIndex');
    }

    public function config()
    {
        return inertia('Config/ConfigIndex');
    }

    public function report()
    {
        return inertia('Report/ReportIndex');
    }
}
