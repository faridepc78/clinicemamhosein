<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\SendActiveCode;
use App\Repositories\BlacklistRepository;
use App\Repositories\UserCodeRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    private $userCodeRepository;
    private $blacklistRepository;

    public function __construct(UserCodeRepository $userCodeRepository,
                                BlacklistRepository $blacklistRepository)
    {
        $this->userCodeRepository = $userCodeRepository;
        $this->blacklistRepository = $blacklistRepository;
    }

    protected function sendFailedLoginResponse(LoginRequest $request)
    {
        throw ValidationException::withMessages([
            'failed' => [trans('auth.failed')],
        ]);
    }

    protected function attemptLogin(LoginRequest $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), true
        );
    }

    protected function credentials(LoginRequest $request)
    {
        return [
            'national_code' => $request->national_code,
            'password' => $request->password
        ];
    }

    public function login(LoginRequest $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            if (!Auth::user()->verify()) {
                $token = Crypt::encryptString(Auth::user()['mobile']);
                $active_code = randomNumbers(6);

                $values =
                    [
                        'active_code' => $active_code,
                        'expire_active_code' => Carbon::now()->addMinutes(15)->toArray()['timestamp'],
                        'resend_active_code' => Carbon::now()->addMinutes(2)->addSeconds(2)->toArray()['timestamp']
                    ];

                $this->userCodeRepository->update($values, Auth::id());

                Auth::user()->notify(new SendActiveCode($active_code));
                newFeedback('پیام', 'حساب کاربری شما هنوز فعال نشده است کد فعالسازی به تلفن همراه شما ارسال شد', 'warning');
                return redirect()->route('verify', 'token=' . $token);
            } else {
                $block_user = $this->blacklistRepository->findByUserId(Auth::id());

                if ($block_user) {
                    if ($block_user['date'] !== null) {
                        $now_date = Carbon::now()->toDateString();

                        if ($block_user['date']>=$now_date) {
                            Auth::logout();
                            newFeedback('پیام', 'حساب کاربری مسدود شده است برای اطلاعات بیشتر با پشتیبانی تماس بگیرید', 'error');
                            return redirect()->back();
                        }else{
                            return $this->sendLoginResponse($request);
                        }
                    } else {
                        newFeedback('پیام', 'حساب کاربری مسدود شده است برای اطلاعات بیشتر با پشتیبانی تماس بگیرید', 'error');
                        return redirect()->back();
                    }
                } else {
                    return $this->sendLoginResponse($request);
                }
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(LoginRequest $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : $this->redirectPath();
    }

    public function redirectPath()
    {
        $role = Auth::user()['role'];
        switch ($role) {
            case User::ADMIN:
                return redirect()->route('dashboard');
            case User::PATIENT:
                return redirect()->route('home');
            case User::CLERK || User::DOCTOR:
                return redirect()->route('doctor_dashboard');
        }
    }
}
