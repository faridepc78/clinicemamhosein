<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ValidationExpireCode implements Rule
{
    public function passes($attribute, $value)
    {
        $now_timestamp = Carbon::now()->toArray()['timestamp'];
        return Auth::user()->code['expire_active_code'] >= $now_timestamp ? true : false;
    }

    public function message()
    {
        return 'کد وارد شده منقضی شده است.';
    }
}
