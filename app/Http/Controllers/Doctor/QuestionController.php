<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Question\AnswerRequest;
use App\Models\Question;
use App\Models\User;
use App\Notifications\AnswerQuestion;
use App\Repositories\QuestionRepository;
use App\Traits\GetDoctorId;
use Exception;

class QuestionController extends Controller
{
    use GetDoctorId;

    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function index()
    {
        $doctor = $this->getDoctor();
        $data = $this->questionRepository->findByDoctor($this->getDoctorId());
        return view('doctor.questions.index', compact('data'));
    }

    public function details($id)
    {
        $doctor = $this->getDoctor();
        $question = $this->questionRepository->findById($id);

        $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $question['doctor_id']]);

        if ($question['status'] == Question::UNREAD) {
            try {
                $this->questionRepository->updateStatus(Question::READE, $id);
            } catch (Exception $exception) {
                newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            }
        }

        return view('doctor.questions.details', compact('question'));
    }

    public function answer(AnswerRequest $request, $id)
    {
        try {
            $question = $this->questionRepository->findById($id);
            $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $question['doctor_id']]);
            $this->questionRepository->answer($request->input('answer'), $id);
            $question->patient->notify(new AnswerQuestion($question->patient->fullName, $question->doctor->fullName));
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }

        return redirect()->route('questions.details', $id);
    }

    public function destroy($id)
    {
        try {
            $question = $this->questionRepository->findById($id);
            $this->authorize('validDataForDoctor', [User::class, $this->getDoctorId(), $question['doctor_id']]);
            $question->delete();
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }

        return redirect()->route('questions.index');
    }
}
