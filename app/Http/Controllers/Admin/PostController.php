<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\Media\MediaRequest;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Services\Media\MediaFileService;
use Exception;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private $postRepository;
    private $categoryRepository;

    public function __construct(PostRepository $postRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->paginateByFilters();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $post = $this->postRepository->store($request);
                $image_id = MediaFileService::publicUpload($request->file('image'),
                    'posts', null)->id;
                $this->postRepository->addImage($image_id, $post->id);
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('posts.create');
    }

    public function edit($id)
    {
        $post = $this->postRepository->findById($id);
        $categories = $this->categoryRepository->getAll();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $post = $this->postRepository->findById($id);

                if ($request->hasFile('image')) {
                    $this->postRepository->update($request, null, $id);
                    $image_id = MediaFileService::publicUpload($request->file('image'),
                        'posts', null)->id;
                    $this->postRepository->addImage($image_id, $post->id);
                    if ($post->image) {
                        $post->image->delete();
                    }
                } else {
                    $this->postRepository->update($request, $post->image_id, $id);
                }
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('posts.edit', $id);
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $post = $this->postRepository->findById($id);

                if ($post->image) {
                    $post->image->delete();
                }

                if (count($post->media)) {
                    foreach ($post->media as $media) {
                        $media->media->delete();
                    }
                }

                $post->delete();
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('posts.index');
    }

    public function media_index($id)
    {
        $post = $this->postRepository->findById($id);
        $media = $this->postRepository->findMediaByPostId($id);
        return view('admin.posts.media.index', compact('post', 'media'));
    }

    public function media_store(MediaRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request) {
                $post = $this->postRepository->storeMedia($request);
                $media_id = MediaFileService::publicUpload($request->file('media'),
                    'posts/media', null)->id;
                $this->postRepository->addMedia($media_id, $post->id);
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('post_media_index', $id);
    }

    public function media_destroy($id, $media_id)
    {
        try {
            DB::transaction(function () use ($media_id) {
                $media = $this->postRepository->findMediaById($media_id);

                if ($media->media) {
                    $media->media->delete();
                }

                $media->delete();
            });
            DB::commit();
            newFeedback();
        } catch (Exception $exception) {
            DB::rollBack();
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('post_media_index', $id);
    }
}
