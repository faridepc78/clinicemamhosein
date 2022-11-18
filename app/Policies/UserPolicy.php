<?php

namespace App\Policies;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected function getData($id)
    {
        return $this->userRepository->findById($id);
    }

    public function update_user(User $user, $id)
    {
        $data = $this->getData($id);

        if ($id == Auth::id() || $data['role'] == User::ADMIN) {
            return false;
        } else {
            return true;
        }
    }

    public function destroy_user(User $user, $id)
    {
        $data = $this->getData($id);

        if ($id == Auth::id() || $data['role'] == User::ADMIN) {
            return false;
        } else {
            return true;
        }
    }

    public function checkDoctor(User $user, $id)
    {
        $data = $this->getData($id);

        if ($data['role'] == User::DOCTOR) {
            return true;
        } else {
            return false;
        }
    }

    public function validDataForDoctor(User $user, $id, $doctor_id)
    {
        return $id == $doctor_id ? true : false;
    }
}
