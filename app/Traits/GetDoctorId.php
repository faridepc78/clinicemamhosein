<?php

namespace App\Traits;

use App\Models\User;
use App\Repositories\DoctorAboutRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

trait GetDoctorId
{
    protected function getDoctorId()
    {
        if (Auth::user()['role'] == User::DOCTOR) {
            return Auth::id();
        } elseif (Auth::user()['role'] == User::CLERK) {
            $doctorAboutRepository = new DoctorAboutRepository();
            return $doctorAboutRepository->findDoctorIdByClerkId(Auth::id());
        }
    }

    protected function getDoctor()
    {
        $userRepository = new UserRepository();
        return $userRepository->findById($this->getDoctorId());
    }
}
