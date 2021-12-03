<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Profile\CreateQuestionRequest;
use App\Http\Requests\Site\Profile\UpdateAvatarRequest;
use App\Http\Requests\Site\Profile\UpdateProfileRequest;
use App\Models\DoctorReserve;
use App\Models\User;
use App\Notifications\CancelReserve;
use App\Notifications\CreateQuestion;
use App\Repositories\DoctorReserveRepository;
use App\Repositories\DoctorTimeRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\UserRepository;
use App\Services\Media\MediaFileService;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

class PanelController extends Controller
{
    private $userRepository;
    private $doctorReserveRepository;
    private $doctorTimeRepository;
    private $questionRepository;

    public function __construct(UserRepository $userRepository,
                                DoctorReserveRepository $doctorReserveRepository,
                                DoctorTimeRepository $doctorTimeRepository,
                                QuestionRepository $questionRepository)
    {
        $this->userRepository = $userRepository;
        $this->doctorReserveRepository = $doctorReserveRepository;
        $this->doctorTimeRepository = $doctorTimeRepository;
        $this->questionRepository = $questionRepository;
    }

    public function profile()
    {
        return view('site.panel.profile');
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        try {
            $this->userRepository->updateProfile($request, Auth::id());
            if (!empty($request->get('password'))) {
                $this->userRepository->updatePassword($request->get('password'), Auth::id());
            }
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('user_profile');
    }

    public function update_avatar(UpdateAvatarRequest $request)
    {
        try {
            $user = $this->userRepository->findById(Auth::id());

            $image_id = MediaFileService::publicUpload($request->file('image'),
                'users', null)->id;

            $this->userRepository->addImage($image_id, $user->id);

            if ($user->image) {
                $user->image->delete();
            }

            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('user_profile');
    }

    public function reserves()
    {
        $reserves = $this->doctorReserveRepository->findByPatientId(Auth::id());
        return view('site.panel.reserves', compact('reserves'));
    }

    public function cancel_reserve()
    {
        try {
            $reserve_id = extractId(request('reserve_id'));
            $reserve = $this->doctorReserveRepository->findById($reserve_id);

            if ($reserve['status'] == DoctorReserve::UNVISITED && $reserve->time->date >= Carbon::now()->toDateString()) {
                $this->doctorTimeRepository->updateCapacity($reserve['time_id'], false);
                $this->doctorReserveRepository->update($reserve_id, DoctorReserve::CANCELED);
                Auth::user()->notify(new CancelReserve(Auth::user()->fullName,$reserve->doctor->fullName));
                newFeedback();
            } else {
                newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            }
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('user_reserves');
    }

    public function questions()
    {
        $questions = $this->questionRepository->findByPatient(Auth::id());
        return view('site.panel.questions', compact('questions'));
    }

    public function questions_details($id)
    {
        $question_id = Hashids::decode($id)[0];
        $question = $this->questionRepository->findById($question_id);
        return view('site.panel.questions_details', compact('question'));
    }

    public function create_questions()
    {
        $doctors = $this->userRepository->findByRole(User::DOCTOR);
        return view('site.panel.create_questions', compact('doctors'));
    }

    public function create_questions_do(CreateQuestionRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $question = $this->questionRepository->store($request);

                if ($request->exists('media')) {
                    $media_id = MediaFileService::publicUpload($request->file('media'),
                        'questions', null)->id;
                    $this->questionRepository->addMedia($media_id, $question->id);
                }

                Auth::user()->notify(new CreateQuestion(Auth::user()->fullName,$question->doctor->fullName));
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('user_questions');
    }
}
