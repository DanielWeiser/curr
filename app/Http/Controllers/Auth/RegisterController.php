<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Currency;
use App\UserCurr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Events\UserRegistered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $create_user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $currency = Currency::all();
          
        if ($create_user['name'] == 'admin') {   
            foreach ($currency as $curr) {
                UserCurr::create([
                    'user_id' => $create_user['id'],
                    'curr_id' => $curr->id,
                    'curr_state' => 1,
                    'req_flag' => 0,
                ]);
            }
        }
        else {
            foreach ($currency as $curr) {
                UserCurr::create([
                    'user_id' => $create_user['id'],
                    'curr_id' => $curr->id,
                    'curr_state' => $curr->state_after_reg,
                    'req_flag' => 0,
                ]);
            }
        }

        event(new UserRegistered($create_user));
        return $create_user;
    }
}
