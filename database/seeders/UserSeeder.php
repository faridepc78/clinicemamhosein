<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::query()->where('role', '=', User::ADMIN)->count()) {
            User::query()->firstOrCreate([
                'f_name' => 'مدیر',
                'l_name' => 'مدیر',
                'ff_name' => null,
                'mobile' => '09123456789',
                'national_code' => '0123456789',
                'birthday' => null,
                'image_id' => null,
                'sex' => User::MALE,
                'password' => bcrypt('09123456789'),
                'status' => User::ACTIVE,
                'role' => User::ADMIN
            ]);
        }
    }
}
