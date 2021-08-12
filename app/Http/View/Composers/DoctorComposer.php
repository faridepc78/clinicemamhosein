<?php


namespace App\Http\View\Composers;


use App\Traits\GetDoctorId;
use Illuminate\View\View;

class DoctorComposer
{
    use GetDoctorId;

    public function compose(View $view)
    {
        $view->with([
            'doctor' => $this->getDoctor()
        ]);
    }
}
