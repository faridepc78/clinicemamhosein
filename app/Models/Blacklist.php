<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

class Blacklist extends Model
{
    protected $table = 'blacklists';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'user_id',
            'date',
            'text'
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function getCovertDateAttribute()
    {
        return $this->date == null ? '_____' : CalendarUtils::strftime('Y/m/d', strtotime($this->date));
    }
}
