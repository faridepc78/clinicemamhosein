<?php

namespace App\Http\Middleware;

use App\Repositories\BlacklistRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BlockUser
{
    private $blacklistRepository;

    public function __construct(BlacklistRepository $blacklistRepository)
    {
        $this->blacklistRepository = $blacklistRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $block_user = $this->blacklistRepository->findByUserId(Auth::id());

            if ($block_user) {
                if ($block_user['date'] !== null) {
                    $now_date = Carbon::now()->toDateString();

                    if ($block_user['date'] >= $now_date) {
                        Auth::logout();
                        newFeedback('پیام', 'حساب کاربری مسدود شده است برای اطلاعات بیشتر با پشتیبانی تماس بگیرید', 'error');
                        return redirect()->route('home');
                    } else {
                        return $next($request);
                    }
                } else {
                    Auth::logout();
                    newFeedback('پیام', 'حساب کاربری مسدود شده است برای اطلاعات بیشتر با پشتیبانی تماس بگیرید', 'error');
                    return redirect()->route('home');
                }
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
