<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorGallery extends Model
{
    protected $table = 'doctors_gallery';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'doctor_id',
            'image_id'
        ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id')->withDefault();
    }
}
