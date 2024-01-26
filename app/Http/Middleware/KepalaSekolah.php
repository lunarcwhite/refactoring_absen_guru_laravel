<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KepalaSekolah
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
            if(auth()->user()->role_id == 3 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2 ){
                return $next($request);
            }
            return redirect()->back();
        
    }
}
