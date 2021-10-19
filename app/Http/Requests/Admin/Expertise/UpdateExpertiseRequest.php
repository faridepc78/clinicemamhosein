<?php

namespace App\Http\Requests\Admin\Expertise;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpertiseRequest extends FormRequest
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
        $id = request()->route('expertise');
        return [
            'name' => ['required', 'string', 'max:255', 'unique:expertises,name,' . $id],
            'slug' => ['required', 'string', 'max:255', 'unique:expertises,slug,' . $id],
            'image' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120']
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
