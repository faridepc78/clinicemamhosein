<?php

namespace App\Http\Requests\Site\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function prepareForValidation()
    {
        if (request('birthday') != null) {
            return $this->merge([
                'birthday' => Jalalian::fromFormat('Y/m/d', convert(request('birthday')))->toCarbon()->toDateString()
            ]);
        }
    }

    public function rules()
    {
        return [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'ff_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
            'sex' => ['required', Rule::in(User::$sex)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed']
        ];
    }

    public function attributes()
    {
        return [
            'f_name' => 'نام',
            'l_name' => 'نام خانوادگی',
            'ff_name' => 'نام پدر',
            'birthday' => 'تاریخ تولد',
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
