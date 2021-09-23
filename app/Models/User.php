<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Vinkla\Hashids\Facades\Hashids;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'f_name',
            'l_name',
            'ff_name',
            'mobile',
            'national_code',
            'birthday',
            'image_id',
            'sex',
            'password',
            'status',
            'role',
            'remember_token'
        ];

    const ADMIN = 'admin';
    const DOCTOR = 'doctor';
    const CLERK = 'clerk';
    const PATIENT = 'patient';
    static $roles =
        [
            self::DOCTOR,
            self::CLERK,
            self::PATIENT
        ];

    const MALE = 'male';
    const FEMALE = 'female';
    static $sex =
        [
            self::MALE,
            self::FEMALE
        ];

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    static $statuses =
        [
            self::ACTIVE,
            self::INACTIVE
        ];


    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id')->withDefault();
    }

    public function code()
    {
        return $this->belongsTo(UserCode::class, 'id', 'user_id')->withDefault();
    }

    /*Start Relations For Doctor*/

    public function doctor()
    {
        return $this->belongsTo(DoctorAbout::class, 'id', 'doctor_id')->withDefault();
    }

    public function gallery()
    {
        return $this->hasMany(DoctorGallery::class, 'doctor_id', 'id');
    }

    public function times()
    {
        return $this->hasMany(DoctorTime::class, 'doctor_id', 'id');
    }

    /*End Relations For Doctor*/

    public function getFullNameAttribute()
    {
        return $this->f_name . ' ' . $this->l_name;
    }

    public function getProfileAttribute()
    {
        return empty($this->image->files)
            ? asset('assets/common/images/profile.png')
            : "/uploads/" . $this->image->files['original'];
    }

    public function verify()
    {
        return $this->status == User::ACTIVE ? true : false;
    }

    public function path()
    {
        return route('doctor', Hashids::encode($this->id) . '-' . str_slug_persian($this->getFullNameAttribute()));
    }
}
