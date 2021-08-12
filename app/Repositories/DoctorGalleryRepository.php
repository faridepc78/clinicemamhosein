<?php

namespace App\Repositories;

use App\Models\DoctorGallery;

class DoctorGalleryRepository
{
    public function store($values)
    {
        return DoctorGallery::query()
            ->create([
            'doctor_id' => $values['doctor_id'],
            'image_id' => null
        ]);
    }

    public function addImage($image_id, $id)
    {
        return DoctorGallery::query()
            ->where('id', '=', $id)
            ->update([
            'image_id' => $image_id
        ]);
    }

    public function paginate($doctor_id)
    {
        return DoctorGallery::query()
            ->where('doctor_id', '=', $doctor_id)
            ->latest()
            ->paginate(10);
    }

    public function findById($id)
    {
        return DoctorGallery::query()
            ->findOrFail($id);
    }
}
