<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthInsurer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check())
        {
            return redirect('/');
        }
        else
        {
            if(Auth::user()->roleDetail('name')['name']!="Insurer")
            {
                return redirect('/');
            }
        }
        return $next($request);
    }
}
