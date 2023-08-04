<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;

class CheckPassword
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
        $pwd = "password";
        if (Hash::check($pwd, auth()->user()->password)) {
            return redirect()->route('change.pwd');
        } else {
            return $next($request);
        }        
    }
}
