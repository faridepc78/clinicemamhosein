<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAbout extends Model
{
    protected $table = 'doctors_about';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'doctor_id',
            'clerk_id',
            'expertise_id',
            'experience',
            'specialized_fields',
            'specialty',
            'science_bar',
            'fluent_languages',
            'place_of_degrees_of_degrees',
            'phone',
            'description'
        ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

    public function clerk()
    {
        return $this->belongsTo(User::class, 'clerk_id', 'id')->withDefault();
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class, 'expertise_id', 'id')->withDefault();
    }
}
