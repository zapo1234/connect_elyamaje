<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        if(auth()->user()->is_admin == 1)
        {
            return $next($request);
        }
        if(auth()->user()->is_admin == 2)
        {
            return $next($request);
        }

        if(auth()->user()->is_admin == 3)
        {
            return $next($request);
        }
        
        if(auth()->user()->is_admin == 11)
        {
            return $nex($request);
        }

        if(auth()->user()->is_admin == 4)
        {
            return $next($request);
        }
        
         if(auth()->user()->is_admin == 5)
        {
            return redirect()->route('login')->with('error','Accès restreint temporairement !');
        }
        
        return $next($request);
           
    }
}
