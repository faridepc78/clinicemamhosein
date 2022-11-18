<?php

namespace App\Http\Requests\Admin\Post\Media;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'post_id' => request()->route('id')
        ]);
    }

    public function rules()
    {
        return [
            'media' => ['required', 'mimes:jpg,png,jpeg', 'max:5120']
        ];
    }

    public function attributes()
    {
        return [
            'media' => 'مدیا پست'
        ];
    }
}
