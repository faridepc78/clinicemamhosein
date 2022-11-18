<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Profile\ProfileRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Media\MediaFileService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $this->authorize('checkDoctor', [User::class, Auth::id()]);
        $user = Auth::user();
        return view('doctor.profile.index', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        try {
            $this->authorize('checkDoctor', [User::class, Auth::id()]);
            DB::transaction(function () use ($request) {
                $user = $this->userRepository->findById(Auth::id());

                if (!empty($request->get('password'))) {
                    $this->userRepository->updatePassword($request->get('password'), Auth::id());
                }

                if ($request->hasFile('image')) {

                    $image_id = MediaFileService::publicUpload($request->file('image'),
                        'users', null)->id;
                    $this->userRepository->addImage($image_id, $user->id);
                    if ($user->image) {
                        $user->image->delete();
                    }
                }

            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('doctor_profile');
    }
}
