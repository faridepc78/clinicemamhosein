<?php

namespace App\Http\Requests\Doctor\Gallery;

use App\Models\User;
use App\Traits\GetDoctorId;
use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    use GetDoctorId;

    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::DOCTOR || auth()->user()['role'] == User::CLERK;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'doctor_id' => $this->getDoctorId()
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
            'image' => 'تصویر گالری'
        ];
    }
}
