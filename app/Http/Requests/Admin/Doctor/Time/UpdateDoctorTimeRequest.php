<?php

namespace App\Http\Requests\Admin\Doctor\Time;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class UpdateDoctorTimeRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'date' => Jalalian::fromFormat('Y/m/d', convert(request('date')))->toCarbon()->toDateString(),
            'doctor_id' => request()->route('id')
        ]);
    }

    public function rules()
    {
        $doctor_id = request()->route('id');
        $date = Jalalian::fromFormat('Y/m/d', convert(request('date')))->toCarbon()->toDateString();
        $id = request()->route('time_id');

        return [
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after::today'],
            'start_time' => ['required', 'numeric',
                Rule::unique('doctors_times')->where(function ($query) use (
                    $doctor_id, $date, $id
                ) {
                    return $query->where('start_time', '=', request('start_time'))
                        ->where('doctor_id', '=', $doctor_id)
                        ->where('date', '=', $date)
                        ->whereNotIn('id', [$id]);
                })],
            'end_time' => ['required', 'numeric', 'gt:start_time',
                Rule::unique('doctors_times')->where(function ($query) use (
                    $doctor_id, $date, $id
                ) {
                    return $query->where('end_time', '=', request('end_time'))
                        ->where('doctor_id', '=', $doctor_id)
                        ->where('date', '=', $date)
                        ->whereNotIn('id', [$id]);
                })],
            'capacity' => ['required', 'numeric', 'min:1']
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'تاریخ ویزیت دکتر',
            'start_time' => 'ساعت شروع ویزیت دکتر',
            'end_time' => 'ساعت پایان ویزیت دکتر',
            'capacity' => 'ظرفیت ویزیت دکتر'
        ];
    }

    public function messages()
    {
        return [
            'date.after' => 'تاریخ ویزیت دکتر باید تاریخی بعد از تاریخ امروز باشد'
        ];
    }
}
