<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Gallery\GalleryRequest;
use App\Models\User;
use App\Repositories\DoctorGalleryRepository;
use App\Services\Media\MediaFileService;
use App\Traits\GetDoctorId;
use Exception;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    use GetDoctorId;

    private $doctorGalleryRepository;

    public function __construct(DoctorGalleryRepository $doctorGalleryRepository)
    {
        $this->doctorGalleryRepository = $doctorGalleryRepository;
    }

    public function index()
    {
        $doctor_id = $this->getDoctorId();
        $doctor = $this->getDoctor();
        $data = $this->doctorGalleryRepository->paginate($doctor_id);
        return view('doctor.gallery.index', compact('data'));
    }

    public function store(GalleryRequest $request)
    {
        try {
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
        return redirect()->route('gallery.index');
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {

                $image = $this->doctorGalleryRepository->findById($id);

                $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $image['doctor_id']]);

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
        return redirect()->route('gallery.index');
    }
}
