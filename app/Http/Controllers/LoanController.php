<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;

class LoanController extends Controller
{

    public function index()
    {
        return inertia('Transaction/Loan/LoanIndex', [
            'farmers' => Farmer::query()->orderByDesc('created_at')->paginate(5),
        ]);
    }
}