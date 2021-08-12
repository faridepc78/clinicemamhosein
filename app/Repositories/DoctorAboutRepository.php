<?php

namespace App\Repositories;

use App\Models\DoctorAbout;
use App\Models\User;

class DoctorAboutRepository
{
    public function store($values)
    {
        return DoctorAbout::query()
            ->create([
            'doctor_id' => $values['doctor_id'],
            'clerk_id' => $values['clerk_id'],
            'expertise_id' => $values['expertise_id'],
            'experience' => $values['experience'],
            'specialized_fields' => $values['specialized_fields'],
            'specialty' => $values['specialty'],
            'science_bar' => $values['science_bar'],
            'fluent_languages' => $values['fluent_languages'],
            'place_of_degrees_of_degrees' => $values['place_of_degrees_of_degrees'],
            'phone' => $values['phone'],
            'description' => $values['description']
        ]);
    }

    public function show($doctor_id)
    {
        $data = DoctorAbout::query()
            ->where('doctor_id', '=', $doctor_id)
            ->get();
        if (count($data)) {
            return $data->first();
        } else {
            return $data->put('status', 'store');
        }
    }

    public function findDoctorIdByClerkId($clerk_id)
    {
        return DoctorAbout::query()
            ->where('clerk_id', '=', $clerk_id)
            ->pluck('doctor_id')
            ->toArray()[0];
    }

    public function update($values, $doctor_id)
    {
        return DoctorAbout::query()
            ->where('doctor_id', '=', $doctor_id)
            ->update([
                'clerk_id' => $values['clerk_id'],
                'expertise_id' => $values['expertise_id'],
                'experience' => $values['experience'],
                'specialized_fields' => $values['specialized_fields'],
                'specialty' => $values['specialty'],
                'science_bar' => $values['science_bar'],
                'fluent_languages' => $values['fluent_languages'],
                'place_of_degrees_of_degrees' => $values['place_of_degrees_of_degrees'],
                'phone' => $values['phone'],
                'description' => $values['description']
        ]);
    }

    public function findByExpertiseId($expertise_id)
    {
        return DoctorAbout::query()
            ->join('users', 'users.id', '=', 'doctors_about.doctor_id')
            ->select('doctors_about.*')
            ->where('doctors_about.expertise_id', '=', $expertise_id)
            ->latest('doctors_about.id')
            ->paginate(10);
    }

    public function getAllFreeClerks($doctor_id)
    {
        return DoctorAbout::query()
            ->rightJoin('users', 'users.id', '=', 'doctors_about.clerk_id')
            ->select('users.*')
            ->where('users.role', '=', User::CLERK)
            ->whereNotIn('users.id', function ($query) use ($doctor_id) {
                $query->select('doctors_about.clerk_id')
                    ->from('doctors_about')
                    ->where('doctors_about.doctor_id', '!=', $doctor_id);
            })
            ->get();
    }
}
