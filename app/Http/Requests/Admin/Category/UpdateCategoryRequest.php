<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $id = request()->route('category');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $id]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام دسته بندی',
            'slug' => 'اسلاگ دسته بندی'
        ];
    }
}
