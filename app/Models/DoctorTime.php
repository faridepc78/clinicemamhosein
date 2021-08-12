<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

class DoctorTime extends Model
{
    protected $table = 'doctors_times';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'doctor_id',
            'date',
            'start_time',
            'end_time',
            'capacity'
        ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

    public function getTimeAttribute()
    {
        return $this->start_time . '-' . $this->end_time;
    }

    public function getFullTimeAttribute()
    {
        return CalendarUtils::strftime('j F Y', strtotime($this->date)) . ' ' . 'ساعت: ' . $this->end_time . '-' . $this->start_time;
    }
}
