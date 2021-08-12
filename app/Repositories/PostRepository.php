<?php

namespace App\Repositories;

use App\Filters\Post\Search;
use App\Filters\Post\Status;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Pipeline\Pipeline;

class PostRepository
{
    public function store($values)
    {
        return Post::query()
            ->create([
            'name' => $values['name'],
            'slug' => $values['slug'],
            'category_id' => $values['category_id'],
            'image_id' => null,
            'text' => $values['text'],
            'status' => $values['status']
        ]);
    }

    public function addImage($image_id, $id)
    {
        return Post::query()
            ->where('id', '=', $id)
            ->update([
            'image_id' => $image_id
        ]);
    }

    public function paginateByFilters()
    {
        return app(Pipeline::class)
            ->send(Post::query())
            ->through([
                Status::class,
                Search::class
            ])
            ->thenReturn()
            ->latest()
            ->paginate(10);
    }

    public function findById($id)
    {
        return Post::query()
            ->findOrFail($id);
    }

    public function update($values, $image_id, $id)
    {
        return Post::query()
            ->where('id', '=', $id)
            ->update([
            'name' => $values['name'],
            'slug' => $values['slug'],
            'category_id' => $values['category_id'],
            'image_id' => $image_id,
            'text' => $values['text'],
            'status' => $values['status']
        ]);
    }

    public function new()
    {
        return Post::query()
            ->where('status', '=', Post::ACTIVE)
            ->latest()
            ->limit(3)
            ->get();
    }

    public function getAllByPaginate()
    {
        return Post::query()
            ->where('status', '=', Post::ACTIVE)
            ->latest()
            ->paginate(10);
    }

    public function findByCategoryId($category_id)
    {
        $data =
            [
                ['status', '=', Post::ACTIVE],
                ['category_id', '=', $category_id]
            ];
        return Post::query()
            ->where($data)
            ->latest()
            ->paginate(10);
    }

    public function related($category_id, $post_id)
    {
        $data =
            [
                ['status', '=', Post::ACTIVE],
                ['category_id', '=', $category_id]
            ];
        return Post::query()
            ->where($data)
            ->whereNotIn('id', [$post_id])
            ->latest()
            ->limit(5)
            ->get();
    }

    public function search($keyword)
    {
        return Post::query()
            ->where('name', 'like', '%' . $keyword . '%')
            ->where('status', '=', Post::ACTIVE)
            ->paginate(10);
    }

    /*START MEDIA*/

    public function findMediaByPostId($post_id)
    {
        return PostMedia::query()
            ->where('post_id', '=', $post_id)
            ->latest()
            ->paginate(10);
    }

    public function storeMedia($values)
    {
        return PostMedia::query()
            ->create([
            'post_id' => $values['post_id'],
            'media_id' => null
        ]);
    }

    public function addMedia($media_id, $id)
    {
        return PostMedia::query()
            ->where('id', '=', $id)
            ->update([
            'media_id' => $media_id
        ]);
    }

    public function findMediaById($id)
    {
        return PostMedia::query()
            ->findOrFail($id);
    }

    /*END MEDIA*/
}
