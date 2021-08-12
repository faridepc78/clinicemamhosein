<?php

namespace App\Repositories;

use App\Models\Expertise;

class ExpertiseRepository
{
    public function store($values)
    {
        return Expertise::query()
            ->create([
            'name' => $values['name'],
            'slug' => $values['slug'],
            'image_id' => null
        ]);
    }

    public function addImage($image_id, $id)
    {
        return Expertise::query()
            ->where('id', '=', $id)
            ->update([
            'image_id' => $image_id
        ]);
    }

    public function paginate()
    {
        return Expertise::query()
            ->latest()
            ->paginate(10);
    }

    public function findById($id)
    {
        return Expertise::query()
            ->findOrFail($id);
    }

    public function update($values, $image_id, $id)
    {
        return Expertise::query()
            ->where('id', '=', $id)
            ->update([
            'name' => $values['name'],
            'slug' => $values['slug'],
            'image_id' => $image_id
        ]);
    }

    public function getAll()
    {
        return Expertise::query()
            ->latest()
            ->get();
    }
}
