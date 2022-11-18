<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Time\StoreDoctorTimeRequest;
use App\Http\Requests\Doctor\Time\UpdateDoctorTimeRequest;
use App\Models\User;
use App\Repositories\DoctorTimeRepository;
use App\Traits\GetDoctorId;
use Exception;

class TimeController extends Controller
{
    use GetDoctorId;

    private $doctorTimeRepository;

    public function __construct(DoctorTimeRepository $doctorTimeRepository)
    {
        $this->doctorTimeRepository = $doctorTimeRepository;
    }

    public function index()
    {
        $doctor_id = $this->getDoctorId();
        $doctor = $this->getDoctor();
        $data = $this->doctorTimeRepository->paginate($doctor_id);
        return view('doctor.times.index', compact('data'));
    }

    public function create()
    {
        $doctor = $this->getDoctor();
        return view('doctor.times.create');
    }

    public function store(StoreDoctorTimeRequest $request)
    {
        try {
            $this->doctorTimeRepository->store($request);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('times.create');
    }

    public function edit($id)
    {
        $doctor = $this->getDoctor();
        $time = $this->doctorTimeRepository->findById($id);
        $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $time['doctor_id']]);
        return view('doctor.times.edit', compact('time'));
    }

    public function update(UpdateDoctorTimeRequest $request, $id)
    {
        try {
            $time = $this->doctorTimeRepository->findById($id);
            $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $time['doctor_id']]);
            $this->doctorTimeRepository->update($request, $id);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('times.edit', $id);
    }

    public function destroy($id)
    {
        try {
            $time = $this->doctorTimeRepository->findById($id);
            $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $time['doctor_id']]);
            $time->delete();
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('times.index');
    }
}
