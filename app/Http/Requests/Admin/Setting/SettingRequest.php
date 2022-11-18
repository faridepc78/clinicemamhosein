<?php

namespace App\Http\Requests\Admin\Setting;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function rules()
    {
        return [
            'terms' => ['required', 'string'],
            'about' => ['required', 'string'],
            'support' => ['required', 'string'],
            'telegram' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255']
        ];
    }

    public function attributes()
    {
        return [
            'terms' => 'صفحه قوانین',
            'about' => 'صفحه درباره ما',
            'support' => 'صفحه پشتیبانی',
            'telegram' => 'تلگرام',
            'instagram' => 'اینستاگرام',
            'linkedin' => 'لینکدین'
        ];
    }
}
