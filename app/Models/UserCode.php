<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    protected $table = 'users_codes';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'user_id',
            'active_code',
            'expire_active_code',
            'resend_active_code'
        ];
}
