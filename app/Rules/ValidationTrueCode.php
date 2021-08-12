<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ValidationTrueCode implements Rule
{
    public function passes($attribute, $value)
    {
        return $value == Auth::user()->code['active_code'] ? true : false;
    }

    public function message()
    {
        return 'کد وارد شده اشتباه است.';
    }
}
