<?php

namespace App\Repositories;

use App\Models\DoctorGallery;
use App\Models\DoctorReserve;
use App\Models\DoctorTime;
use App\Models\Expertise;
use App\Models\Post;
use App\Models\Question;
use App\Models\User;

class StatisticsRepository
{
    /*START FOR ADMIN PANEL*/

    public function getCountExpertises()
    {
        return Expertise::query()->count();
    }

    public function getCountUsers()
    {
        return User::query()->count();
    }

    public function getCountPosts()
    {
        return Post::query()->count();
    }

    public function getCountReserves()
    {
        return DoctorReserve::query()->count();
    }

    /*END FOR ADMIN PANEL*/

    /*START FOR DOCTOR PANEL*/

    public function getCountDoctorTimes($doctor_id)
    {
        return DoctorTime::query()
            ->where('doctor_id', '=', $doctor_id)
            ->count();
    }

    public function getCountDoctorReserves($doctor_id)
    {
        return DoctorReserve::query()
            ->where('doctor_id', '=', $doctor_id)
            ->count();
    }

    public function getCountDoctorQuestions($doctor_id)
    {
        return Question::query()
            ->where('doctor_id', '=', $doctor_id)
            ->count();
    }

    public function getCountDoctorGallery($doctor_id)
    {
        return DoctorGallery::query()
            ->where('doctor_id', '=', $doctor_id)
            ->count();
    }

    /*END FOR DOCTOR PANEL*/
}
