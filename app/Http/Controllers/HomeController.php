<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        return to_route('login');

//        return inertia('Welcome', [
//            'canLogin' => Route::has('login'),
//            'canRegister' => Route::has('register')
//        ]);
    }
}
