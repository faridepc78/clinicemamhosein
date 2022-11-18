<?php

namespace App\Rules;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class ValidationUserRole implements Rule
{
    private $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function passes($attribute, $value)
    {
        try {
            $userRepository = new UserRepository();
            $user = $userRepository->findById($value);
            return $user['role'] == $this->role ? true : false;
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            return redirect()->back();
        }
    }

    public function message()
    {
        return 'کاربر مجوز دسترسی برای این عملیات را ندارد.';
    }
}
