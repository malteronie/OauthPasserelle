<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $pwd = 'password';
        if (Hash::check($pwd, auth()->user()->password)) {
            return redirect()->route('change.pwd');
        } else {
            return $next($request);
        }
    }
}
