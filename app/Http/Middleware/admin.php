<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        

        if(Auth::check())
        {
            if(Auth::user()->isAdmin==true)
            {   
                return $next($request);
            }
            else{
                return redirect('/')->with('message', 'Nejste administrátor');
            }

        }
        else{
            return redirect('/login')->with('message', 'Pro přístup do administrace se přihlaste');
        }
        
    }
}
