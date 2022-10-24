<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostCreateRequest;
use App\Http\Requests\Api\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Return all posts
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        // Сделать реквест валидацию данных
        //        dd(explode(',', \request()->get('tag_id')));
        //        return PostResource::collection(\Cache::remember('posts', 60*60*24, function () {
        //            return Post::with(['post_category', 'post_tags', 'comments'])->get();
        //        }));
        return PostResource::collection(Post::with([
            'post_category',
            'post_tags',
            'comments',
        ])
            ->when($request->has('tag_id'), function ($query) use ($request) {
                $query->whereHas('post_tags', function ($q) use ($request) {
                    $q->whereIn('id', $request->get('tag_id'));
                });
            })
            ->when($request->has('cat_id'), function ($query) use ($request) {
                $query->whereHas('post_category', function ($q) use ($request) {
                    $q->where('id', '=', $request->get('cat_id'));
                });
            })
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('title', 'like',
                    '%' . $request->get('search') . '%');
            })
            ->paginate());
    }

    /**
     * Return post by id
     *
     * @param $id
     *
     * @return \App\Http\Resources\PostResource
     */
    public function show($id)
    {
        return PostResource::make(Post::with([
            'post_category',
            'post_tags',
            'comments',
        ])
            ->findOrFail($id));
    }

    /**
     * Create new post
     *
     * @param   \App\Http\Requests\Api\PostCreateRequest  $postCreateRequest
     *
     * @return \App\Http\Resources\PostResource|string[]
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function store(PostCreateRequest $postCreateRequest)
    {
        $post = new Post();

        $post->user_id      = auth()->id();
        $post->title        = $postCreateRequest->get('title');
        $post->category_id  = $postCreateRequest->get('category_id');
        $post->slug         = $postCreateRequest->get('slug');
        $post->excerpt      = $postCreateRequest->get('excerpt');
        $post->content      = $postCreateRequest->get('content');
        $post->is_published = $postCreateRequest->get('is_published');
        $post->is_hide      = $postCreateRequest->get('is_hide');
        $post->image        = $postCreateRequest->get('image');

        $post->save();

        //Tags
        $add_post_tag =
            $this->postService->savePostTags($postCreateRequest->get('tag_ids'),
                $post);

        if ( ! $add_post_tag) {
            return ['msg' => 'Update tags error'];
        }

        if ( ! $post) {
            return ['msg' => 'Save Error'];
        }

        return PostResource::make($post);
    }

    /**
     * Update post by id
     *
     * @param   \App\Http\Requests\Api\PostUpdateRequest  $postUpdateRequest
     * @param   int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $postUpdateRequest, int $id)
    {
        $post = Post::find($id);

        if ($post->user_id !== auth()->id()) {
            return ['msg' => 'Update error'];
        }
        $post->user_id      = auth()->id();
        $post->title        = $postUpdateRequest->get('title');
        $post->category_id  = $postUpdateRequest->get('category_id');
        $post->slug         = $postUpdateRequest->get('slug');
        $post->excerpt      = $postUpdateRequest->get('excerpt');
        $post->content      = $postUpdateRequest->get('content');
        $post->is_published = $postUpdateRequest->get('is_published');
        $post->is_hide      = $postUpdateRequest->get('is_hide');
        $post->image        = $postUpdateRequest->get('image');

        $add_post_tag =
            $this->postService->savePostTags($postUpdateRequest->get('tag_ids'),
                $post);

        if ( ! $add_post_tag) {
            return back()
                ->withErrors(['msg' => 'Update tags error'])
                ->withInput();
        }

        $result = $post->update();

        if ( ! $result) {
            return ['msg' => 'Update Error'];
        }

        return PostResource::make($post);
    }

    /**
     * Delete post by id
     *
     * @param   int  $id
     *
     * @return string[]
     */
    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            return ['msg' => 'Delete error'];
        }

        $result = $post->delete();

        if ( ! $result) {
            return ['msg' => 'Delete error'];
        }

        return ['success' => 'Delete success'];
    }
}
