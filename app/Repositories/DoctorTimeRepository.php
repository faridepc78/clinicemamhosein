<?php

namespace App\Repositories;

use App\Filters\Time\Search;
use App\Filters\Time\Status;
use App\Models\DoctorTime;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Carbon;

class DoctorTimeRepository
{
    public function store($values)
    {
        return DoctorTime::query()
            ->create([
            'doctor_id' => $values['doctor_id'],
            'date' => $values['date'],
            'start_time' => $values['start_time'],
            'end_time' => $values['end_time'],
            'capacity' => $values['capacity']
        ]);
    }

    public function paginate($doctor_id)
    {
        return app(Pipeline::class)
            ->send(DoctorTime::query())
            ->through([
                Status::class,
                Search::class
            ])
            ->thenReturn()
            ->where('doctor_id', '=', $doctor_id)
            ->latest()
            ->paginate(10);
    }

    public function findById($id)
    {
        return DoctorTime::query()
            ->findOrFail($id);
    }

    public function update($values, $id)
    {
        return DoctorTime::query()
            ->where('id', '=', $id)
            ->update([
            'date' => $values['date'],
            'start_time' => $values['start_time'],
            'end_time' => $values['end_time'],
            'capacity' => $values['capacity']
        ]);
    }

    public function findActiveByDoctorId($doctor_id)
    {
        $data =
            [
                ['doctor_id', '=', $doctor_id],
                ['date', '>=', Carbon::now()->toDateString()],
                ['capacity', '>=', 1],
            ];
        return DoctorTime::query()
            ->where($data)
            ->orderBy('date', 'asc')
            ->get();
    }

    public function updateCapacity($id, bool $status)
    {
        $data = $this->findById($id);

        if ($status == true) {
            $capacity = $data['capacity'] + 1;
        } else {
            $capacity = $data['capacity'] - 1;
        }

        return DoctorTime::query()
            ->where('id', '=', $id)
            ->update([
            'capacity' => $capacity
        ]);
    }
}
