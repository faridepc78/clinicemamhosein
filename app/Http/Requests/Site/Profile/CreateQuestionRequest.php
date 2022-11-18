<?php

namespace App\Http\Requests\Site\Profile;

use App\Models\Question;
use App\Models\User;
use App\Rules\ValidationUserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'patient_id' => Auth::id(),
            'answer' => null,
            'status' => Question::UNREAD
        ]);
    }

    public function rules()
    {
        return [
            'doctor_id' => ['required', 'exists:users,id', new ValidationUserRole(User::DOCTOR)],
            'media' => ['nullable', 'mimes:jpg,png,jpeg', 'max:5120'],
            'subject' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string']
        ];
    }

    public function attributes()
    {
        return [
            'doctor_id' => 'دکتر',
            'media' => 'فایل پیوست',
            'subject' => 'موضوع سوال',
            'message' => 'متن سوال'
        ];
    }
}
