<?php

namespace App\Http\Controllers;

use App\Models\InvoiceTrade;
use App\Models\TradeDetail;
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

    public function test()
    {
        $trade = TradeDetail::query()
            ->with(['farmer', 'trade.details', 'invoice_trade.invoice.expense', 'invoice_trade.invoice.trade_details'])
            ->where('id', 4)->first();

        return $trade;
    }
}
