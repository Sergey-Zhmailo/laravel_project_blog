<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\PostCreateRequest;
use App\Http\Requests\Front\PostUpdateRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postService->getAllUserWithPaginate(6);

        return view('front.auth.user_posts', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();

        $post_tags = [];

        $categories = PostCategory::query()
            ->select('id', 'title')
            ->toBase()
            ->get();

        $tags = PostTag::query()
            ->get();

        return view('front.auth.post_edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'post_tags' => $post_tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $postCreateRequest)
    {
        $data['title'] = $postCreateRequest->get('title');
        $data['category_id'] = $postCreateRequest->get('category_id');
        $data['slug'] = $postCreateRequest->get('slug');
        $data['excerpt'] = $postCreateRequest->get('excerpt');
        $data['content'] = $postCreateRequest->get('content');
        $data['is_published'] = boolval($postCreateRequest->get('is_published'));
        $data['is_hide'] = boolval($postCreateRequest->get('is_hide'));
        $data['published_at'] = $postCreateRequest->get('published_at');

        $post = (new Post())->create($data);

        //Tags
        $add_post_tag = $this->postService->savePostTags($postCreateRequest->get('tag_ids'), $post);

        if (!$add_post_tag) {
            return back()
                ->withErrors(['msg' => 'Update tags error'])
                ->withInput();
        }

        // Image
        if ($postCreateRequest->file('image')) {
            $image = $this->postService->savePostImage($postCreateRequest->file('image'), $post);
        }

        if ($post) {
            return redirect()->route('posts.edit', $post->id)
                ->with(['success' => 'Save success']);
        } else {
            return back()
                ->withErrors(['msg' => 'Save Error'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $post = Post::with(['post_category', 'post_tags', 'comments'])
            ->where('slug', $slug)
            ->first();

        if (!$post) {
            abort(404);
        }

        $tags = PostTag::all('id', 'title', 'slug');
        $categories = PostCategory::all('id', 'title', 'slug');

        return view('front.post_show', [
            'post' => $post,
            'tags' => $tags,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $post = Post::with('post_tags')->where('user_id', '=', auth('web')->id())->find($id);

        $post_tags = $post->post_tags->map(function ($post_tag) {
            return $post_tag->id;
        });

        $post_tags = $post_tags->toArray();

        $categories = PostCategory::query()
            ->select('id', 'title')
            ->toBase()
            ->get();

        $tags = PostTag::query()
            ->get();

        if (empty($post)) {
            abort(404);
        }

        return view('front.auth.post_edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'post_tags' => $post_tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $postUpdateRequest, int $id)
    {
        $post = Post::find($id);

        if ($post->user_id !== auth('web')->id()) {
            abort(404);
        }

        $data['title'] = $postUpdateRequest->get('title');
        $data['category_id'] = $postUpdateRequest->get('category_id');
        $data['slug'] = $postUpdateRequest->get('slug');
        $data['excerpt'] = $postUpdateRequest->get('excerpt');
        $data['content'] = $postUpdateRequest->get('content');
        $data['is_published'] = boolval($postUpdateRequest->get('is_published'));
        $data['is_hide'] = boolval($postUpdateRequest->get('is_hide'));
        $data['published_at'] = $postUpdateRequest->get('published_at');

        //Tags
        $add_post_tag = $this->postService->savePostTags($postUpdateRequest->get('tag_ids'), $post);

        if (!$add_post_tag) {
            return back()
                ->withErrors(['msg' => 'Update tags error'])
                ->withInput();
        }

        // Image
        if ($postUpdateRequest->file('image')) {
            $image = $this->postService->savePostImage($postUpdateRequest->file('image'), $post);
        }

        $result = $post->update($data);

        if ($result) {
            return redirect()
                ->route('posts.edit', $post->id)
                ->with(['success' => 'Update success']);
        } else {
            return back()
                ->withErrors(['msg' => 'Update error'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            Storage::delete($post->image);
        }

        $result = Post::destroy($id);

        if ($result) {
            return back()
                ->with(['success' => 'Delete success']);
        } else {
            return back()
                ->withErrors(['msg' => 'Delete error']);
        }
    }
}
