<?php

namespace App\Http\Requests\Doctor\Question;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::DOCTOR || auth()->user()['role'] == User::CLERK;
    }

    public function rules()
    {
        return [
            'answer' => ['required', 'string']
        ];
    }

    public function attributes()
    {
        return [
            'answer' => 'جواب سوال'
        ];
    }
}
