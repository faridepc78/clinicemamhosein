<?php

namespace App\Repositories;

use App\Filters\User\Role;
use App\Filters\User\Search;
use App\Models\User;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function store($values)
    {
        return User::query()
            ->create([
                'f_name' => $values['f_name'],
                'l_name' => $values['l_name'],
                'ff_name' => $values['ff_name'],
                'mobile' => $values['mobile'],
                'national_code' => $values['national_code'],
                'birthday' => $values['birthday'],
                'image_id' => null,
                'sex' => $values['sex'],
                'password' => bcrypt($values['password']),
                'status' => $values['status'],
                'role' => $values['role']
            ]);
    }

    public function addImage($image_id, $id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->update([
                'image_id' => $image_id
            ]);
    }

    public function findById($id)
    {
        return User::query()
            ->findOrFail($id);
    }

    public function update($values, $image_id, $id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->update([
                'f_name' => $values['f_name'],
                'l_name' => $values['l_name'],
                'ff_name' => $values['ff_name'],
                'mobile' => $values['mobile'],
                'national_code' => $values['national_code'],
                'birthday' => $values['birthday'],
                'image_id' => $image_id,
                'sex' => $values['sex'],
                'role' => $values['role']
            ]);
    }

    public function updateProfile($values, $id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->update([
                'f_name' => $values['f_name'],
                'l_name' => $values['l_name'],
                'ff_name' => $values['ff_name'],
                'birthday' => $values['birthday'],
                'sex' => $values['sex']
            ]);
    }

    public function findByNationalCode($national_code)
    {
        return User::query()
            ->where('national_code', '=', $national_code)
            ->first();
    }

    public function updatePassword($password, $id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->update([
                'password' => bcrypt($password)
            ]);
    }

    public function verify($id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->update([
                'status' => User::ACTIVE
            ]);
    }

    public function roleFilter()
    {
        return app(Pipeline::class)
            ->send(User::query())
            ->through([
                Role::class,
                Search::class
            ])
            ->thenReturn()
            ->latest()
            ->paginate(10);
    }

    public function findByRole($role, $count = null)
    {
        if ($count == null) {
            return User::query()
                ->where('role', '=', $role)
                ->latest()
                ->get();
        } else {
            return User::query()
                ->where('role', '=', $role)
                ->latest()
                ->limit($count)
                ->get();
        }
    }

    public function popularDoctors()
    {
        return User::query()
            ->select(DB::raw('users.*, count(doctors_reserves.doctor_id) as aggregate'))
            ->join('doctors_reserves', 'doctors_reserves.doctor_id', '=', 'users.id')
            ->groupBy('users.id')
            ->orderBy('aggregate', 'desc')
            ->limit(10)
            ->get();
    }

    public function searchDoctor($keyword)
    {
        $data = User::query()
            ->join('doctors_about', 'doctors_about.doctor_id', '=', 'users.id')
            ->join('expertises', 'expertises.id', '=', 'doctors_about.expertise_id')
            ->select('users.*')
            ->with('doctor')
            ->where('users.f_name', 'like', '%' . $keyword . '%')
            ->orWhere('users.l_name', 'like', '%' . $keyword . '%')
            ->orWhereRaw("concat(users.f_name, ' ', users.l_name) like '%$keyword%' ")
            ->orWhere('expertises.name', 'like', '%' . $keyword . '%');

        return $data->where('role', '=', User::DOCTOR)->paginate(10);
    }
}
