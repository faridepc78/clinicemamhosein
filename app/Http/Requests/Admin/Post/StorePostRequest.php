<?php

namespace App\Http\Requests\Admin\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:posts,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5120'],
            'text' => ['required', 'string'],
            'status' => ['required', Rule::in(Post::$statuses)]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام پست',
            'slug' => 'اسلاگ پست',
            'category_id' => 'دسته بندی پست',
            'image' => 'تصویر پست',
            'text' => 'توضیحات پست',
            'status' => 'وضعیت پست'
        ];
    }
}
