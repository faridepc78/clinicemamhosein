<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidationMobile implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^09[0-9]{9}$/', $value);
    }

    public function message()
    {
        return 'تلفن همراه کاربر نامعتبر است.';
    }
}
