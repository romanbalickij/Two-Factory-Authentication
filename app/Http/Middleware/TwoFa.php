<?php

namespace App\Http\Middleware;

use Closure;

class TwoFa
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
        if(auth()->user()->isVerified == 1) {
            return $next($request);
        }
            return redirect('/verifyOTP');

    }
}
