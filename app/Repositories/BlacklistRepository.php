<?php

namespace App\Repositories;

use App\Filters\Blacklist\Search;
use App\Models\Blacklist;
use App\Models\User;
use Illuminate\Pipeline\Pipeline;

class BlacklistRepository
{
    public function store($values)
    {
        return Blacklist::query()
            ->create([
            'user_id' => $values['user_id'],
            'date' => $values['date'],
            'text' => $values['text']
        ]);
    }

    public function paginateBySearch()
    {
        return app(Pipeline::class)
            ->send(Blacklist::query())
            ->through([
                Search::class
            ])
            ->thenReturn()
            ->latest()
            ->paginate(10);
    }

    public function findById($id)
    {
        return Blacklist::query()
            ->findOrFail($id);
    }

    public function update($values, $id)
    {
        return Blacklist::query()
            ->where('id', '=', $id)
            ->update([
            'user_id' => $values['user_id'],
            'date' => $values['date'],
            'text' => $values['text']
        ]);
    }

    public function findByUserId($user_id)
    {
        return Blacklist::query()
            ->where('user_id', '=', $user_id)
            ->first();
    }

    public function getAllUserId()
    {
        return Blacklist::query()
            ->select('user_id')
            ->get()
            ->toArray();
    }

    public function getUserNotBlock($user_id = null)
    {
        $user_blocks = $this->getAllUserId();

        if ($user_id != null) {
            return User::query()
                ->where('role', '=', User::PATIENT)
                ->whereNotIn('id', $user_blocks)
                ->orWhereIn('id', [$user_id])
                ->get();
        } else {
            return User::query()
                ->where('role', '=', User::PATIENT)
                ->whereNotIn('id', $user_blocks)
                ->get();
        }
    }
}
