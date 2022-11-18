<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotRequest;
use App\Notifications\SendPasswordCode;
use App\Repositories\UserRepository;
use Exception;

class ForgotPasswordController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show()
    {
        return view('auth.forgot');
    }

    public function send(ForgotRequest $request)
    {
        try {
            $national_code = $request->input('national_code');
            $user = $this->userRepository->findByNationalCode($national_code);

            if (!$user) {
                return redirect()->route('forgot')->withErrors(['failed'=>'کاربری با این تلفن همراه در سیستم ثبت نشده است']);
            }else{
                $password = randomNumbers(8);
                $this->userRepository->updatePassword($password, $user['id']);
                $user->notify(new SendPasswordCode($password));
                newFeedback('پیام', 'رمز عبور جدید برای شما ارسال شد', 'success');
                return redirect()->route('login');
            }
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            return redirect()->route('forgot');
        }
    }
}
