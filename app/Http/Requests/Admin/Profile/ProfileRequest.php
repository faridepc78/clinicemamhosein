<?php

namespace App\Http\Requests\Admin\Profile;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Rules\ValidationMobile;
use App\Rules\ValidationNationalCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        $userRepository = new UserRepository();
        $user = $userRepository->findById(Auth::id());

        if (request('birthday') != null) {
            return $this->merge([
                'birthday' => Jalalian::fromFormat('Y/m/d', convert(request('birthday')))->toCarbon()->toDateString(),
                'role' => User::ADMIN,
                'ff_name' => $user['ff_name']
            ]);
        } else {
            return $this->merge([
                'role' => User::ADMIN,
                'ff_name' => $user['ff_name']
            ]);
        }
    }

    public function rules()
    {
        return [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric', 'digits:11', new ValidationMobile()],
            'national_code' => ['required', 'numeric', 'digits:10', new ValidationNationalCode()],
            'birthday' => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
            'image' => ['nullable', 'mimes:jpg,png,jpeg', 'max:5120'],
            'sex' => ['required', Rule::in(User::$sex)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes()
    {
        return [
            'f_name' => 'نام',
            'l_name' => 'نام خانوادگی',
            'mobile' => 'تلفن همراه',
            'national_code' => 'کد ملی',
            'birthday' => 'تاریخ تولد',
            'image' => 'پروفایل',
            'sex' => 'جنسیت',
            'password' => 'رمز عبور'
        ];
    }

    public function messages()
    {
        return [
            'birthday.before' => 'تاریخ تولد باید تاریخی قبل از تاریخ امروز باشد'
        ];
    }
}
