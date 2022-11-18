<?php

namespace App\Http\Requests\Admin\Expertise;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpertiseRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'slug' => str_slug_persian(request('slug'))
        ]);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:expertises,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:expertises,slug'],
            'image' => ['required', 'mimes:jpg,png,jpeg,svg', 'max:5120']
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام تخصص',
            'slug' => 'اسلاگ تخصص',
            'image' => 'تصویر تخصص'
        ];
    }
}
