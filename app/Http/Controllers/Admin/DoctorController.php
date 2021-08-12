<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Doctor\About\AboutRequest;
use App\Http\Requests\Admin\Doctor\Gallery\GalleryRequest;
use App\Http\Requests\Admin\Doctor\Time\StoreDoctorTimeRequest;
use App\Http\Requests\Admin\Doctor\Time\UpdateDoctorTimeRequest;
use App\Models\User;
use App\Repositories\DoctorAboutRepository;
use App\Repositories\DoctorGalleryRepository;
use App\Repositories\DoctorReserveRepository;
use App\Repositories\DoctorTimeRepository;
use App\Repositories\ExpertiseRepository;
use App\Repositories\UserRepository;
use App\Services\Media\MediaFileService;
use Exception;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    private $userRepository;
    private $expertiseRepository;
    private $doctorAboutRepository;
    private $doctorGalleryRepository;
    private $doctorTimeRepository;
    private $doctorReserveRepository;

    public function __construct(UserRepository $userRepository,
                                ExpertiseRepository $expertiseRepository,
                                DoctorAboutRepository $doctorAboutRepository,
                                DoctorGalleryRepository $doctorGalleryRepository,
                                DoctorTimeRepository $doctorTimeRepository,
                                DoctorReserveRepository $doctorReserveRepository)
    {
        $this->userRepository = $userRepository;
        $this->expertiseRepository = $expertiseRepository;
        $this->doctorAboutRepository = $doctorAboutRepository;
        $this->doctorGalleryRepository = $doctorGalleryRepository;
        $this->doctorTimeRepository = $doctorTimeRepository;
        $this->doctorReserveRepository = $doctorReserveRepository;
    }

    public function index($id)
    {
        $this->authorize('checkDoctor', [User::class, $id]);
        $doctor = $this->userRepository->findById($id);
        return view('admin.doctor.index', compact('doctor'));
    }

    public function management_about($id)
    {
        $this->authorize('checkDoctor', [User::class, $id]);
        $doctor = $this->userRepository->findById($id);
        $clerks = $this->doctorAboutRepository->getAllFreeClerks($id);
        $expertises = $this->expertiseRepository->getAll();
        $info = $this->doctorAboutRepository->show($id);

        if ($info['status'] == 'store') {
            $info =
                [
                    'id' => 0,
                    'clerk_id' => null,
                    'expertise_id' => null,
                    'experience' => null,
                    'specialized_fields' => null,
                    'specialty' => null,
                    'science_bar' => null,
                    'fluent_languages' => null,
                    'place_of_degrees_of_degrees' => null,
                    'phone' => null,
                    'description' => null,
                    'status' => 'store'
                ];
        }

        return view('admin.doctor.management.about.index',
            compact('doctor', 'clerks', 'expertises', 'info'));
    }

    public function management_about_do(AboutRequest $request, $id)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);

            $info = $this->doctorAboutRepository->show($id);

            if ($info['status'] == 'store') {
                $this->doctorAboutRepository->store($request);
            } else {
                $this->doctorAboutRepository->update($request, $id);
            }

            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_about', $id);
    }

    public function management_gallery($id)
    {
        $this->authorize('checkDoctor', [User::class, $id]);
        $doctor = $this->userRepository->findById($id);
        $data = $this->doctorGalleryRepository->paginate($id);
        return view('admin.doctor.management.gallery.index', compact('doctor', 'data'));
    }

    public function management_gallery_do(GalleryRequest $request, $id)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);
            DB::transaction(function () use ($request) {
                $gallery = $this->doctorGalleryRepository->store($request);
                $image_id = MediaFileService::publicUpload($request->file('image'),
                    'doctors/gallery', null)->id;
                $this->doctorGalleryRepository->addImage($image_id, $gallery->id);
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_gallery', $id);
    }

    public function management_gallery_destroy($id, $destroy_id)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);

            DB::transaction(function () use ($destroy_id) {
                $image = $this->doctorGalleryRepository->findById($destroy_id);

                if ($image->image) {
                    $image->image->delete();
                }

                $image->delete();
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_gallery', $id);
    }

    public function management_times_index($id)
    {
        $this->authorize('checkDoctor', [User::class, $id]);
        $doctor = $this->userRepository->findById($id);
        $data = $this->doctorTimeRepository->paginate($id);
        return view('admin.doctor.management.times.index',
            compact('doctor', 'data'));
    }

    public function management_times_create($id)
    {
        $this->authorize('checkDoctor', [User::class, $id]);
        $doctor = $this->userRepository->findById($id);
        return view('admin.doctor.management.times.create', compact('doctor'));
    }

    public function management_times_store(StoreDoctorTimeRequest $request, $id)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);
            $this->doctorTimeRepository->store($request);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_times_create', $id);
    }

    public function management_times_edit($id, $time_id)
    {
        $this->authorize('checkDoctor', [User::class, $id]);
        $doctor = $this->userRepository->findById($id);
        $time = $this->doctorTimeRepository->findById($time_id);
        return view('admin.doctor.management.times.edit', compact('doctor', 'time'));
    }

    public function management_times_update(UpdateDoctorTimeRequest $request, $id, $time_id)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);
            $this->doctorTimeRepository->update($request, $time_id);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_times_edit', [$id, $time_id]);
    }

    public function management_times_destroy($id, $time_id)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);
            $time = $this->doctorTimeRepository->findById($time_id);
            $time->delete();
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_times_index', $id);
    }

    public function management_reserves_index($id)
    {
        $this->authorize('checkDoctor', [User::class, $id]);
        $doctor = $this->userRepository->findById($id);
        $data = $this->doctorReserveRepository->paginateByFilters($id);
        return view('admin.doctor.management.reserves.index',
            compact('doctor', 'data'));
    }

    public function management_reserves_change_status($id, $reserve_id, $status)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);
            $this->doctorReserveRepository->update($reserve_id, $status);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_reserves_index', $id);
    }

    public function management_reserves_destroy($id, $reserve_id)
    {
        try {
            $this->authorize('checkDoctor', [User::class, $id]);

            DB::transaction(function () use ($id, $reserve_id) {
                $reserve = $this->doctorReserveRepository->findById($reserve_id);
                $reserve->delete();
                $this->doctorTimeRepository->updateCapacity($reserve['time_id'], true);
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('management_doctor_reserves_index', $id);
    }
}
