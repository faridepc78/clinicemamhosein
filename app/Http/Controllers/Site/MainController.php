<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegisterReserve;
use App\Repositories\DoctorAboutRepository;
use App\Repositories\DoctorReserveRepository;
use App\Repositories\DoctorTimeRepository;
use App\Repositories\ExpertiseRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

class MainController extends Controller
{
    private $expertiseRepository;
    private $doctorAboutRepository;
    private $doctorTimeRepository;
    private $userRepository;
    private $doctorReserveRepository;
    private $postRepository;

    public function __construct(ExpertiseRepository $expertiseRepository,
                                DoctorAboutRepository $doctorAboutRepository,
                                DoctorTimeRepository $doctorTimeRepository,
                                UserRepository $userRepository,
                                DoctorReserveRepository $doctorReserveRepository,
                                PostRepository $postRepository)
    {
        $this->expertiseRepository = $expertiseRepository;
        $this->doctorAboutRepository = $doctorAboutRepository;
        $this->doctorTimeRepository = $doctorTimeRepository;
        $this->userRepository = $userRepository;
        $this->doctorReserveRepository = $doctorReserveRepository;
        $this->postRepository = $postRepository;
    }

    public function home()
    {
        $expertises = $this->expertiseRepository->getAll();
        $doctors = $this->userRepository->findByRole(User::DOCTOR);
        $doctors_sliders = $this->userRepository->findByRole(User::DOCTOR, 10);
        $popular_doctors = $this->userRepository->popularDoctors();
        $new_posts = $this->postRepository->new();
        return view('site.home.index',
            compact('expertises', 'doctors',
                'doctors_sliders', 'popular_doctors', 'new_posts'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $doctors = $this->userRepository->searchDoctor($keyword);
        return view('site.search.index', compact('doctors'));
    }

    public function expertise($slug)
    {
        $id = extractId($slug);
        $expertise = $this->expertiseRepository->findById($id);
        $doctors = $this->doctorAboutRepository->findByExpertiseId($id);
        return view('site.expertise.index', compact('expertise', 'doctors'));
    }

    public function doctor($slug)
    {
        $id = extractId($slug);
        $doctor = $this->userRepository->findById($id);
        $times = $this->doctorTimeRepository->findActiveByDoctorId($id);
        return view('site.doctor.index', compact('doctor', 'times'));
    }

    public function reserve(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $time_id = Hashids::decode($request->get('time_id'))[0];
                $time = $this->doctorTimeRepository->findById($time_id);
                $patient_id = Auth::id();
                $doctor_id = $time['doctor_id'];
                $expertise_id = $time->doctor->doctor['expertise_id'];

                $result = $this->doctorReserveRepository->check($expertise_id, $patient_id);

                $values =
                    [
                        'doctor_id' => $doctor_id,
                        'expertise_id' => $expertise_id,
                        'patient_id' => $patient_id,
                        'time_id' => $time_id
                    ];

                if ($result == false) {
                    if ($time['capacity'] >= 1) {
                        $this->doctorTimeRepository->updateCapacity($time_id, false);
                        $data = $this->doctorReserveRepository->store($values);
                        Auth::user()->notify(new RegisterReserve(Auth::user()->fullName, $time->doctor->fullName));
                        newFeedback('پیام', 'نوبت شما با موفقیت ثبت شد', 'success');
                    } else {
                        newFeedback('پیام', 'ظرفیت این زمان تکمیل شده است', 'warning');
                    }
                } else {
                    newFeedback('پیام', 'شما در یک روز قادر به گرفتن یک نوبت از یک تخصص هستید', 'warning');
                }

                DB::commit();
            });
        } catch (Exception $exception) {
            dd($exception);
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }

        return redirect()->route('user_reserves');
    }

    public function about_us()
    {
        return view('site.about-us.index');
    }

    public function support()
    {
        return view('site.support.index');
    }

    public function terms_and_conditions()
    {
        return view('site.terms-and-conditions.index');
    }
}
