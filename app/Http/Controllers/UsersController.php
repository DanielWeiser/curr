<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\UserCurr;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function index()
    {
        $users = User::all();
        /**
         * $user_curr - array with username key and user and his currencies information value ($user_inf)
         *
         */
        $user_curr = array();
        foreach ($users as $user) {
            if($user->name == 'admin') 
                continue;
            $user_inf = DB::table('user_curr')->join('users', 'users.id', '=', 'user_curr.user_id')->join('currency', 'currency.id', '=', 'user_curr.curr_id')
                    ->select('email',  'curr_name', 'code', 'flag', 'user_id', 'curr_id', 'curr_state')->where('user_id', '=', $user->id)->get();
            $user_curr += [$user->name => $user_inf];
        }
        return view('users', ['users' => $user_curr]);
    }
    /**
     * functions for change user information from users page
     * param[0] - user id, param[1] - updated value
     */
    public function update_name($inf)
    {
        $param = explode("&", $inf);
        User::where('id', '=', $param[0])->update(['name' => $param[1]]);
    }
    public function update_email($inf)
    {
        $param = explode("&", $inf);
        User::where('id', '=', $param[0])->update(['email' => $param[1]]);
    }
    public function off_curr($inf)
    {
        $param = explode("&", $inf);
        UserCurr::where([['user_id', '=', $param[0]], ['curr_id', '=', $param[1]]])->update(['curr_state' => 0]);
    }
    public function on_curr($inf)
    {
        $param = explode("&", $inf);
        UserCurr::where([['user_id', '=', $param[0]], ['curr_id', '=', $param[1]]])->update(['curr_state' => 1]);
    }
}
