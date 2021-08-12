<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDoctorAndClerk
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()['role'] == User::DOCTOR || Auth::user()['role'] == User::CLERK) {
            return $next($request);
        } else {
            return abort(403);
        }
    }
}
