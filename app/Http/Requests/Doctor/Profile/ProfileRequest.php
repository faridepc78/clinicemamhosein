<?php

namespace App\Http\Requests\Doctor\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::DOCTOR;
    }

    public function rules()
    {
        return [
            'image' => ['nullable', 'mimes:jpg,png,jpeg', 'max:5120'],
            'password' => ['nullable', 'string', 'min:8','confirmed'],
        ];
    }

    public function attributes()
    {
        return [
            'image' => 'پروفایل',
            'password' => 'رمز عبور'
        ];
    }
}
