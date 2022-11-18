<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()['status'] == User::ACTIVE) {
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}
