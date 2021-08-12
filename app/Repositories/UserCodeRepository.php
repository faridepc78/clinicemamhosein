<?php

namespace App\Repositories;

use App\Models\UserCode;

class UserCodeRepository
{
    public function store($values)
    {
        return UserCode::query()
            ->create([
            'user_id' => $values['user_id'],
            'active_code' => $values['active_code'],
            'expire_active_code' => $values['expire_active_code'],
            'resend_active_code' => $values['resend_active_code']
        ]);
    }

    public function update($values, $user_id)
    {
        return UserCode::query()
            ->where('user_id', '=', $user_id)
            ->update([
            'active_code' => $values['active_code'],
            'expire_active_code' => $values['expire_active_code'],
            'resend_active_code' => $values['resend_active_code']
        ]);
    }
}
