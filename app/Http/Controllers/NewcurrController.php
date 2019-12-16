<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserCurr;

class NewcurrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index()
    {
        $add_curr = DB::table('currency')->join('user_curr', 'currency.id', '=', 'user_curr.curr_id')
                    ->select('id', 'curr_name', 'code', 'flag')->where([['user_id', '=', Auth::id()], ['curr_state', '=', 0], ['req_flag', '=', 0]])->get();
        return view('newcurr', ['currency' => $add_curr]);
    }

    /**
     * new currency 
     */
    public function add_curr($id)
    {
        UserCurr::where([['user_id', '=', Auth::id()], ['curr_id', '=', $id]])
                ->update(['req_flag' => 1]);
    }
}
