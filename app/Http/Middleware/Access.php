<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Access
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
        $uri=str_replace('http://127.0.0.1:8000/admin/', '', url()->current());

        if(Auth::user()->isAdmin)
        {
            if(json_decode(Auth::user()->isAllowed)->$uri){
                return $next($request);}
            else{
                return redirect('/admin')->with('message', 'nemáte přístup!!');
            }}
        else{return redirect('/')->with('message', 'nejste administrátor');}
    }
}
