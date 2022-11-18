<?php

namespace App\Http\Requests\Admin\Doctor\About;

use App\Models\User;
use App\Rules\ValidationUserRole;
use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        if (request()->method === 'POST') {
            return $this->merge([
                'doctor_id' => request()->route('id')
            ]);
        }
    }

    public function rules()
    {
        $id = request()->route('update_id');
        $role = User::CLERK;

        $rules = [
            'clerk_id' => ['required', 'exists:users,id', 'unique:doctors_about,clerk_id', new ValidationUserRole($role)],
            'expertise_id' => ['required', 'exists:expertises,id'],
            'experience' => ['required', 'numeric', 'min:1', 'max:50'],
            'specialized_fields' => ['required', 'string', 'max:255'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'science_bar' => ['nullable', 'string', 'max:255'],
            'fluent_languages' => ['nullable', 'string', 'max:255'],
            'place_of_degrees_of_degrees' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'numeric', 'unique:doctors_about,phone'],
            'description' => ['nullable', 'string']
        ];

        if (request()->method === 'PATCH') {
            $rules['clerk_id'] = ['required', 'exists:users,id', 'unique:doctors_about,clerk_id,' . $id, new ValidationUserRole($role)];
            $rules['phone'] = ['nullable', 'numeric', 'unique:doctors_about,phone,' . $id];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'clerk_id' => 'منشی دکتر',
            'expertise_id' => 'تخصص دکتر',
            'experience' => 'سال تجربه دکتر',
            'specialized_fields' => 'حوزه تخصصی دکتر',
            'specialty' => 'فوق تخصص دکتر',
            'science_bar' => 'مرتبه علمی دکتر',
            'fluent_languages' => 'زبان های مسلط دکتر',
            'place_of_degrees_of_degrees' => 'محل اخذ مدرک تحصیلی دکتر',
            'phone' => 'تلفن دکتر',
            'description' => 'توضیحات دکتر'
        ];
    }
}
