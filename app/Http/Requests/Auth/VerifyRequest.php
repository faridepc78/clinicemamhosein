<?php

namespace App\Http\Requests\Auth;

use App\Rules\ValidationExpireCode;
use App\Rules\ValidationTrueCode;
use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'active_code' => ['required', 'numeric', 'digits:6',
                new ValidationTrueCode(),
                new ValidationExpireCode()],
            'g-recaptcha-response' => ['required', 'captcha']
        ];
    }

    public function attributes()
    {
        return [
            'activation_code' => 'کد فعالسازی'
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'فیلد ریکپچا الزامی است',
            'g-recaptcha-response.captcha' => 'لطفا فیلد ریکپچا را مجداد پر کنید'
        ];
    }
}
