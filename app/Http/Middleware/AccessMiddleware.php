<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AccessMiddleware
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
        if(Auth::user()->role != 'unknown'){
            return $next($request);
        }else{
            alert()->warning('هشدار','سطح دسترسی شما هنوز مورد تایید قرار نگرفته است')->autoClose(6000);
            return redirect('/');
        }
    }
}
