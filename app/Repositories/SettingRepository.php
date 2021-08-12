<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    public function store($values)
    {
        return Setting::query()
            ->create([
                'terms' => $values['terms'],
                'about' => $values['about'],
                'support' => $values['support'],
                'telegram' => $values['telegram'],
                'instagram' => $values['instagram'],
                'linkedin' => $values['linkedin']
            ]);
    }

    public function show()
    {
        $data = Setting::query()
            ->get();
        if (count($data)) {
            return $data->first();
        } else {
            return $data->put('status', 'store');
        }
    }

    public function update($values, $id)
    {
        return Setting::query()
            ->where('id', '=', $id)
            ->update([
                'terms' => $values['terms'],
                'about' => $values['about'],
                'support' => $values['support'],
                'telegram' => $values['telegram'],
                'instagram' => $values['instagram'],
                'linkedin' => $values['linkedin']
            ]);
    }
}
