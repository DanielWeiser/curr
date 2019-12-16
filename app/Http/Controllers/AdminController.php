<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserCurr;
use Illuminate\Support\Facades\Mail;
use App\Mail\usermail;
use App\Events\ResponseToRequest;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function index()
    {
        $requests = DB::table('user_curr')->join('users', 'users.id', '=', 'user_curr.user_id')->join('currency', 'currency.id', '=', 'user_curr.curr_id')
                    ->select('name', 'email', 'code', 'flag', 'users.id as user_id', 'currency.id as curr_id')->where('req_flag', '=', 1)->get();
        return view('admin', ['user_req' => $requests]);
    }
    /**
     * enable currency and mail 
     */
    public function del_curr($id)
    {  
        $param = explode("&", $id);
        UserCurr::where([['user_id', '=', $param[0]], ['curr_id', '=', $param[1]]])
                ->update(['req_flag' => 0, 'curr_state' => 1]);
    }
    /**
     * reject request and mail 
     */
    public function del_curr_mail($id)
    {  
        $param = explode("&", $id);
        UserCurr::where([['user_id', '=', $param[0]], ['curr_id', '=', $param[1]]])
                ->update(['req_flag' => 0, 'curr_state' => 0]);
    }
    /**
     * send email (param[2] - success flag, param[0] - email, param[1] - currency code, param[3] - user_id)
     */
    public function mail($inf)
    {
        $param = explode("&", $inf);
        if($param[2]) {
            $message = 'Currency ' . $param[1] . ' added!';
            Mail::to($param[0])->send(new usermail($message));
            $response = array("user_id" => $param[3], "message" => $message);
        }
        else {
            $message = 'Currency ' . $param[1] . ' is not added!';
            Mail::to($param[0])->send(new usermail($message));
            $response = array("user_id" => $param[3], "message" => $message);
        }
        event(new ResponseToRequest($response));
    }
}
