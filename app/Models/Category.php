<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'name',
            'slug'
        ];

    public function path()
    {
        return route('category', Hashids::encode($this->id) . '-' . $this->slug);
    }
}
