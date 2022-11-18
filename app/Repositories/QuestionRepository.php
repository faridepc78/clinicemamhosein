<?php

namespace App\Repositories;

use App\Filters\Question\Search;
use App\Filters\Question\Status;
use App\Models\Question;
use Illuminate\Pipeline\Pipeline;

class QuestionRepository
{
    public function store($values)
    {
        return Question::query()
            ->create([
                'patient_id' => $values['patient_id'],
                'doctor_id' => $values['doctor_id'],
                'media_id' => null,
                'subject' => $values['subject'],
                'message' => $values['message'],
                'answer' => $values['answer'],
                'status' => $values['status']
            ]);
    }

    public function addMedia($media_id, $id)
    {
        return Question::query()
            ->where('id', '=', $id)
            ->update([
                'media_id' => $media_id
            ]);
    }

    public function findById($id)
    {
        return Question::query()
            ->findOrFail($id);
    }

    public function findByPatient($patient_id)
    {
        return app(Pipeline::class)
            ->send(Question::query())
            ->through([
                Status::class,
                \App\Filters\Question\UserPanel\Search::class
            ])
            ->thenReturn()
            ->where('patient_id', '=', $patient_id)
            ->latest()
            ->paginate(10);
    }

    public function findByDoctor($doctor_id)
    {
        return app(Pipeline::class)
            ->send(Question::query())
            ->through([
                Status::class,
                Search::class
            ])
            ->thenReturn()
            ->where('doctor_id', '=', $doctor_id)
            ->latest()
            ->paginate(10);
    }

    public function updateStatus($status, $id)
    {
        return Question::query()
            ->where('id', '=', $id)
            ->update([
                'status' => $status
            ]);
    }

    public function answer($answer, $id)
    {
        return Question::query()
            ->where('id', '=', $id)
            ->update([
                'answer' => $answer
            ]);
    }
}
