<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\StatisticsRepository;
use App\Traits\GetDoctorId;

class DashboardController extends Controller
{
    use GetDoctorId;

    private $statisticsRepository;

    public function __construct(StatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function index()
    {
        $doctor_id = $this->getDoctorId();

        $getCountDoctorTimes = $this->statisticsRepository->getCountDoctorTimes($doctor_id);
        $getCountDoctorReserves = $this->statisticsRepository->getCountDoctorReserves($doctor_id);
        $getCountDoctorQuestions = $this->statisticsRepository->getCountDoctorQuestions($doctor_id);
        $getCountDoctorGallery = $this->statisticsRepository->getCountDoctorGallery($doctor_id);

        return view('doctor.dashboard.index',
            compact('getCountDoctorTimes', 'getCountDoctorReserves',
                'getCountDoctorQuestions', 'getCountDoctorGallery'));
    }
}
