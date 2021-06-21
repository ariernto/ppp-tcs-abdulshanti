<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LoginCheck
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            if (Auth::user()->status == 'active') {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
