<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Vinkla\Hashids\Facades\Hashids;

class Post extends Model
{
    protected $table = 'posts';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'name',
            'slug',
            'category_id',
            'image_id',
            'text',
            'status'
        ];

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    static $statuses =
        [
            self::ACTIVE,
            self::INACTIVE
        ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id')->withDefault();
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class, 'post_id', 'id');
    }

    public function path()
    {
        return route('post', Hashids::encode($this->id) . '-' . $this->slug);
    }

    public function status()
    {
        if ($this->status == Post::ACTIVE) {
            return '<td class="alert alert-success">'.Lang::get(self::ACTIVE).'</td>';
        } elseif ($this->status == Post::INACTIVE) {
            return '<td class="alert alert-danger">'.Lang::get(self::INACTIVE).'</td>';
        }
    }
}
