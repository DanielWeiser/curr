<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\MongoRates;

class StartController extends Controller
{
    public function index()
    {
        $total = MongoRates::count();
        $rates = MongoRates::skip($total - 8)->get();
        //dd(phpinfo());
        // $json = file_get_contents("../node/history.json"); //json currency rate
        $curr = Currency::where('code', '=', 'RUB')->orWhere('code', '=', 'JPY')->orWhere('code', '=', 'CNY')->get();
        return view('welcome', ['currency' => $curr, 'history' => $rates]);
    }
}
