<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\DoctorReserveRepository;
use App\Traits\GetDoctorId;
use Exception;

class ReserveController extends Controller
{
    use GetDoctorId;

    private $doctorReserveRepository;

    public function __construct(DoctorReserveRepository $doctorReserveRepository)
    {
        $this->doctorReserveRepository = $doctorReserveRepository;
    }

    public function index()
    {
        $doctor = $this->getDoctor();
        $data = $this->doctorReserveRepository->paginateByFilters($this->getDoctorId());
        return view('doctor.reserves.index', compact('data'));
    }

    public function change_status($id, $status)
    {
        try {
            $data = $this->doctorReserveRepository->findById($id);
            $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $data['doctor_id']]);
            $this->doctorReserveRepository->update($id, $status);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('reserves.index');
    }
}
