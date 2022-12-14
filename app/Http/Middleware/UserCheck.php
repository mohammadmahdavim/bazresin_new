<?php

namespace App\Http\Middleware;

use Closure;

class UserCheck
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
        if(auth()->check()){
            if( in_array(auth()->user()->role,['user','bazres','admin']) ){

                return $next($request);
            }
            return back();
        }
        return back();
    }
}
