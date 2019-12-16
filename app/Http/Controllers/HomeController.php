<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //All user's currencies
        $currency = DB::table('user_curr')->join('users', 'users.id', '=', 'user_curr.user_id')->join('currency', 'currency.id', '=', 'user_curr.curr_id')
                    ->select('rate', 'code', 'flag')
                    ->where([['user_id', '=', Auth::id()], ['curr_state', '=', 1]])->get();
        return view('home', ['currency' => $currency, 'user_name' => Auth::user()->name]);
    }
}
