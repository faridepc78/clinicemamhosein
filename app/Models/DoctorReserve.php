<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class DoctorReserve extends Model
{
    protected $table = 'doctors_reserves';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'doctor_id',
            'expertise_id',
            'patient_id',
            'time_id',
            'date',
            'status'
        ];

    const VISITED = 'visited';
    const UNVISITED = 'unvisited';
    const CANCELED = 'canceled';
    static $statuses =
        [
            self::VISITED,
            self::UNVISITED,
            self::CANCELED
        ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class, 'expertise_id', 'id')->withDefault();
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id')->withDefault();
    }

    public function time()
    {
        return $this->belongsTo(DoctorTime::class, 'time_id', 'id')->withDefault();
    }

    public function status()
    {
        if ($this->status == DoctorReserve::VISITED) {
            return '<td class="alert alert-success">'.Lang::get(self::VISITED).'</td>';
        } elseif ($this->status == DoctorReserve::UNVISITED) {
            return '<td class="alert alert-warning">'.Lang::get(self::UNVISITED).'</td>';
        } elseif ($this->status == DoctorReserve::CANCELED) {
            return '<td class="alert alert-danger">'.Lang::get(self::CANCELED).'</td>';
        }
    }
}
