<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ProfileRequest;
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
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = $this->userRepository->findById(Auth::id());

                if ($request->hasFile('image')) {
                    $this->userRepository->update($request, null, Auth::id());
                    $image_id = MediaFileService::publicUpload($request->file('image'),
                        'users', null)->id;
                    $this->userRepository->addImage($image_id, $user->id);
                    if ($user->image) {
                        $user->image->delete();
                    }
                } else {
                    $this->userRepository->update($request, $user->image_id, Auth::id());
                }

                if (!empty($request->get('password'))) {
                    $this->userRepository->updatePassword($request->get('password'), Auth::id());
                }

            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('profile');
    }
}
