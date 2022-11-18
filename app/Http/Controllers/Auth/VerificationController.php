<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyRequest;
use App\Notifications\SendActiveCode;
use App\Repositories\UserCodeRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class VerificationController extends Controller
{
    private $userRepository;
    private $userCodeRepository;

    public function __construct(UserRepository $userRepository, UserCodeRepository $userCodeRepository)
    {
        $this->userRepository = $userRepository;
        $this->userCodeRepository = $userCodeRepository;
    }

    public function show()
    {
        try {
            if (request()->input('token')) {
                if (Crypt::decryptString(request()->input('token')) == Auth::user()['mobile']) {
                    $resend_active_code = Auth::user()->code['resend_active_code'];
                    return view('auth.verify', compact('resend_active_code'));
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        } catch (Exception $exception) {
            abort(404);
        }
    }

    public function verify(VerifyRequest $request)
    {
        try {
            $this->userRepository->verify(Auth::id());
            Auth::logout();
            newFeedback('پیام', 'حساب کاربری شما فعال شد', 'success');
            return redirect()->route('login');
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            return redirect()->back();
        }
    }

    public function resend()
    {
        try {
            $now_timestamp = Carbon::now()->toArray()['timestamp'];

            if ($now_timestamp > Auth::user()->code['resend_active_code']) {
                $active_code = randomNumbers(6);
                $values =
                    [
                        'active_code' => $active_code,
                        'expire_active_code' => Carbon::now()->addMinutes(15)->toArray()['timestamp'],
                        'resend_active_code' => Carbon::now()->addMinutes(2)->addSeconds(2)->toArray()['timestamp']
                    ];

                $this->userCodeRepository->update($values, Auth::id());
                Auth::user()->notify(new SendActiveCode($active_code));
                newFeedback('پیام', 'کد فعالسازی حساب کاربری مجددا برای شما ارسال شد', 'success');
                return redirect()->back();
            } else {
                return redirect()->back()->
                withErrors(['resend_active_code_message' => 'درخواست شما نامعتبر است لطفا بعد از 2 دقیقه مجددا تلاش کنید.']);
            }
        }catch (Exception $exception){
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            return redirect()->back();
        }
    }
}
