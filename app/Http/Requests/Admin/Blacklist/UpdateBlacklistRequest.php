<?php

namespace App\Http\Requests\Admin\Blacklist;

use App\Models\User;
use App\Rules\ValidationUserRole;
use Illuminate\Foundation\Http\FormRequest;
use Morilog\Jalali\Jalalian;

class UpdateBlacklistRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        if (request('date') != null) {
            return $this->merge([
                'date' => Jalalian::fromFormat('Y/m/d', convert(request('date')))->toCarbon()->toDateString()
            ]);
        }
    }

    public function rules()
    {
        $id = request()->route('blacklist');
        return [
            'user_id' => ['required', 'exists:users,id', 'unique:blacklists,id,' . $id, new ValidationUserRole(User::PATIENT)],
            'date' => ['nullable', 'date', 'date_format:Y-m-d', 'after::today'],
            'text' => ['nullable', 'string']
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'کاربر لیست سیاه',
            'date' => 'تاریخ پایان بلاک کاربر',
            'text' => 'توضیحات بلاک کاربر'
        ];
    }

    public function messages()
    {
        return [
            'date.after' => 'تاریخ پایان بلاک کاربر باید تاریخی بعد از تاریخ امروز باشد'
        ];
    }
}
