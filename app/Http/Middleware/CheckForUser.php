<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckForUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /**
     * If admin then redirect 
     *
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->name == 'admin') 
            return redirect('/admin');
        else
            return $next($request);  
    }
}
