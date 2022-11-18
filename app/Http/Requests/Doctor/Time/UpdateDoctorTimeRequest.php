<?php

namespace App\Http\Requests\Doctor\Time;

use App\Models\User;
use App\Traits\GetDoctorId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class UpdateDoctorTimeRequest extends FormRequest
{
    use GetDoctorId;

    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::DOCTOR || auth()->user()['role'] == User::CLERK;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'date' => Jalalian::fromFormat('Y/m/d', convert(request('date')))->toCarbon()->toDateString(),
            'doctor_id' => $this->getDoctorId()
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
            'date' => 'تاریخ ویزیت',
            'start_time' => 'ساعت شروع ویزیت',
            'end_time' => 'ساعت پایان ویزیت',
            'capacity' => 'ظرفیت ویزیت'
        ];
    }

    public function messages()
    {
        return [
            'date.after' => 'تاریخ ویزیت باید تاریخی بعد از تاریخ امروز باشد'
        ];
    }
}
