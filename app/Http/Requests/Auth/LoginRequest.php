<?php

namespace App\Http\Requests\Auth;

use App\Rules\ValidationNationalCode;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'national_code' => ['required', 'numeric', 'digits:10', new ValidationNationalCode()],
            'password' => ['required', 'string'],
            'g-recaptcha-response' => ['required', 'captcha']
        ];
    }

    public function attributes()
    {
        return [
            'national_code' => 'کد ملی',
            'password' => 'رمز عبور'
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
