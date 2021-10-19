<?php

namespace App\Http\Requests\Admin\Doctor\Gallery;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'doctor_id' => request()->route('id')
        ]);
    }

    public function rules()
    {
        return [
            'image' => ['required', 'mimes:jpg,png,jpeg,jfif', 'max:5120']
        ];
    }

    public function attributes()
    {
        return [
            'image' => 'تصویر گالری دکتر'
        ];
    }
}
