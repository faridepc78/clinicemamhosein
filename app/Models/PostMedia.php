<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    protected $table = 'posts_media';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at'
        ];

    protected $fillable =
        [
            'post_id',
            'media_id'
        ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id')->withDefault();
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id')->withDefault();
    }
}
