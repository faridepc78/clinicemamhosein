<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function store($values)
    {
        return Category::query()
            ->create([
            'name' => $values['name'],
            'slug' => $values['slug']
        ]);
    }

    public function paginate()
    {
        return Category::query()
            ->latest()
            ->paginate(10);
    }

    public function findById($id)
    {
        return Category::query()
            ->findOrFail($id);
    }

    public function update($values, $id)
    {
        return Category::query()
            ->where('id', '=', $id)
            ->update([
            'name' => $values['name'],
            'slug' => $values['slug']
        ]);
    }

    public function getAll()
    {
        return Category::query()
            ->latest()
            ->get();
    }
}
