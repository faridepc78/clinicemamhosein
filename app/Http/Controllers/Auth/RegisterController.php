<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\SendActiveCode;
use App\Repositories\UserCodeRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller
{
    use RegistersUsers;

    private $userRepository;
    private $userCodeRepository;

    public function __construct(UserRepository $userRepository,
                                UserCodeRepository $userCodeRepository)
    {
        $this->userRepository = $userRepository;
        $this->userCodeRepository = $userCodeRepository;
    }

    public function register(RegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user, true);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect()->route('verify');
    }

    protected function create(array $data)
    {
        try {
            $user = $this->userRepository->store($data);
            $values =
                [
                    'user_id' => $user['id'],
                    'active_code' => randomNumbers(6),
                    'expire_active_code' => Carbon::now()->addMinutes(15)->toArray()['timestamp'],
                    'resend_active_code' => Carbon::now()->addMinutes(2)->addSeconds(2)->toArray()['timestamp']
                ];
            $this->userCodeRepository->store($values);
            return $user;
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            return redirect()->route('register');
        }
    }

    public function registered(Request $request, User $user)
    {
        $token = Crypt::encryptString($user['mobile']);
        try {
            $user->notify(new SendActiveCode($user->code['active_code']));
            newFeedback('پیام', 'ثبت نام با موفقیت انجام شد و کد فعالسازی به تلفن همراه شما ارسال شد', 'success');
            return redirect()->route('verify', 'token=' . $token);
        } catch (Exception $exception) {
            newFeedback('پیام', 'ثبت نام با موفقیت انجام شد ولی کد ارسال نشد! لطفا مجددا درخواست کد فعالسازی را انجام دهید', 'warning');
            return redirect()->route('verify', 'token=' . $token);
        }
    }
}
