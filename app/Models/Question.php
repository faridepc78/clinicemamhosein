<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Question extends Model
{
    protected $table = 'questions';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'patient_id',
            'doctor_id',
            'media_id',
            'subject',
            'message',
            'answer',
            'status'
        ];

    const READE = 'read';
    const UNREAD = 'unread';
    static $statuses =
        [
            self::READE,
            self::UNREAD
        ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id')->withDefault();
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id')->withDefault();
    }

    public function status()
    {
        if ($this->status == Question::READE) {
            return '<td class="alert alert-success">'.Lang::get(self::READE).'</td>';
        } elseif ($this->status == Question::UNREAD) {
            return '<td class="alert alert-danger">'.Lang::get(self::UNREAD).'</td>';
        }
    }
}
