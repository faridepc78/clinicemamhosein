<?php

namespace App\Repositories;

use App\Filters\Reserve\Search;
use App\Filters\Reserve\Status;
use App\Models\DoctorReserve;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Carbon;

class DoctorReserveRepository
{
    public function check($expertise_id, $patient_id)
    {
        $data =
            [
                ['expertise_id', '=', $expertise_id],
                ['patient_id', '=', $patient_id],
                ['date', '=', Carbon::now()->toDateString()]
            ];

        return DoctorReserve::query()
            ->where($data)
            ->exists();
    }

    public function store($values)
    {
        return DoctorReserve::query()
            ->create([
            'doctor_id' => $values['doctor_id'],
            'expertise_id' => $values['expertise_id'],
            'patient_id' => $values['patient_id'],
            'time_id' => $values['time_id'],
            'date' => Carbon::now()->toDateString(),
            'status' => DoctorReserve::UNVISITED
        ]);
    }

    public function update($id, $status)
    {
        return DoctorReserve::query()
            ->where('id', '=', $id)->update([
            'status' => $status
        ]);
    }

    public function paginateByFilters($doctor_id)
    {
        return app(Pipeline::class)
            ->send(DoctorReserve::query())
            ->through([
                Status::class,
                Search::class
            ])
            ->thenReturn()
            ->where('doctor_id', '=', $doctor_id)
            ->orderBy('created_at', 'asc')
            ->paginate(10);
    }

    public function findById($id)
    {
        return DoctorReserve::query()
            ->findOrFail($id);
    }

    public function findByPatientId($patient_id)
    {
        return app(Pipeline::class)
            ->send(DoctorReserve::query())
            ->through([
                Status::class,
                \App\Filters\Reserve\User\Search::class
            ])
            ->thenReturn()
            ->where('patient_id', '=', $patient_id)
            ->latest()
            ->paginate(10);
    }
}
