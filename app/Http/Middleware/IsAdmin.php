<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
class IsAdmin
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
     if(Auth::user() != NULL){
     if (Auth::user()->id == 1) {
            return $next($request);
     }
     else{
         return redirect('/accesodenegado');
     }
     }
     else {
         return redirect('/accesodenegado');
     }
 
    }
}
