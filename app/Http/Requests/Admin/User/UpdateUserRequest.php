<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Rules\ValidationMobile;
use App\Rules\ValidationNationalCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        $id = request()->route('user');
        $userRepository = new UserRepository();
        $user = $userRepository->findById($id);

        if (request('birthday') != null) {
            return $this->merge([
                'birthday' => Jalalian::fromFormat('Y/m/d', convert(request('birthday')))->toCarbon()->toDateString(),
                'ff_name' => $user['ff_name']
            ]);
        } else {
            return $this->merge([
                'ff_name' => $user['ff_name']
            ]);
        }
    }

    public function rules()
    {
        $id = request()->route('user');
        return [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric', 'digits:11', 'unique:users,mobile,' . $id, new ValidationMobile()],
            'national_code' => ['required', 'numeric', 'digits:10', 'unique:users,national_code,' . $id, new ValidationNationalCode()],
            'birthday' => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
            'image' => ['nullable', 'mimes:jpg,png,jpeg', 'max:5120'],
            'sex' => ['required', Rule::in(User::$sex)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(User::$roles)]
        ];
    }

    public function attributes()
    {
        return [
            'f_name' => 'نام کاربر',
            'l_name' => 'نام خانوادگی کاربر',
            'mobile' => 'تلفن همراه کاربر',
            'national_code' => 'کد ملی کاربر',
            'birthday' => 'تاریخ تولد کاربر',
            'image' => 'پروفایل کاربر',
            'sex' => 'جنسیت کاربر',
            'password' => 'رمز عبور کاربر',
            'role' => 'نقش کاربر'
        ];
    }

    public function messages()
    {
        return [
            'birthday.before' => 'تاریخ تولد کاربر باید تاریخی قبل از تاریخ امروز باشد'
        ];
    }
}
