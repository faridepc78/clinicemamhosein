<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Media\MediaFileService;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->roleFilter();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = $this->userRepository->store($request);
                if ($request->exists('image')) {
                    $image_id = MediaFileService::publicUpload($request->file('image'),
                        'users', null)->id;
                    $this->userRepository->addImage($image_id, $user->id);
                }
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('users.create');
    }

    public function edit($id)
    {
        $this->authorize('update_user', [User::class, $id]);
        $user = $this->userRepository->findById($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $this->authorize('update_user', [User::class, $id]);

            DB::transaction(function () use ($request, $id) {
                $user = $this->userRepository->findById($id);

                if ($request->hasFile('image')) {
                    $this->userRepository->update($request, null, $id);
                    $image_id = MediaFileService::publicUpload($request->file('image'),
                        'users', null)->id;
                    $this->userRepository->addImage($image_id, $user->id);
                    if ($user->image) {
                        $user->image->delete();
                    }
                } else {
                    $this->userRepository->update($request, $user->image_id, $id);
                }

                if (!empty($request->get('password'))) {
                    $this->userRepository->updatePassword($request->get('password'), $id);
                }

            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
        	DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('users.edit', $id);
    }

    public function destroy($id)
    {
        try {
            $this->authorize('destroy_user', [User::class, $id]);

            DB::transaction(function () use ($id) {
                $user = $this->userRepository->findById($id);

                if ($user->image) {
                    $user->image->delete();
                }
                $user->delete();
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('users.index');
    }
}
