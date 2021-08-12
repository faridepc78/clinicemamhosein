<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\ValidationMobile;
use App\Rules\ValidationNationalCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        if (request('birthday') != null) {
            $birthday = Jalalian::fromFormat('Y/m/d', convert(request('birthday')))->toCarbon()->toDateString();
        } else {
            $birthday = null;
        }

        return $this->merge([
            'birthday' => $birthday,
            'password' => request('mobile'),
            'status' => User::INACTIVE,
            'role' => User::PATIENT
        ]);
    }

    public function rules()
    {
        return [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'ff_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric', 'digits:11', 'unique:users,mobile', new ValidationMobile()],
            'national_code' => ['required', 'numeric', 'digits:10', 'unique:users,national_code', new ValidationNationalCode()],
            'birthday' => ['required', 'date', 'date_format:Y-m-d', 'before::today'],
            'sex' => ['required', Rule::in(User::$sex)],
            'g-recaptcha-response' => ['required', 'captcha']
        ];
    }

    public function attributes()
    {
        return [
            'f_name' => 'نام',
            'l_name' => 'نام خانوادگی',
            'ff_name' => 'نام پدر',
            'mobile' => 'شماره موبایل',
            'national_code' => 'کد ملی',
            'birthday' => 'تاریخ تولد',
            'sex' => 'جنسیت'
        ];
    }

    public function messages()
    {
        return [
            'birthday.before' => 'تاریخ تولد باید تاریخی قبل از تاریخ امروز باشد',
            'g-recaptcha-response.required' => 'فیلد ریکپچا الزامی است',
            'g-recaptcha-response.captcha' => 'لطفا فیلد ریکپچا را مجداد پر کنید'
        ];
    }
}
