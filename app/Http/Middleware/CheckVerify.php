<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CheckVerify
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guest()) {
            return $next($request);
        } else {
            if (Auth::user()->verify()) {
                return redirect()->route('home');
            } else {
                if (!$request->routeIs('verify')) {
                    $token = Crypt::encryptString(Auth::user()['mobile']);
                    return redirect()->route('verify', 'token=' . $token);
                }else{
                    return $next($request);
                }
            }
        }
    }
}
