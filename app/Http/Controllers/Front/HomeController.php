<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\SearchRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display homepage
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = $this->postService->getAllPublicWithPaginate(6);
        $tags = PostTag::query()
            ->withCount(['posts' => function (Builder $query) {
                $query->where('is_published', '=', true)
                    ->where('is_hide', '=', false);
            }])
            ->get();
        $categories = PostCategory::query()
            ->withCount(['posts' => function (Builder $query) {
                $query->where('is_published', '=', true)
                    ->where('is_hide', '=', false);
            }])
            ->get();

        return view('front.home', [
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories
        ]);
    }

    /**
     * Display one post on front
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $slug)
    {
        $post = Post::with(['post_category:id,title,id,slug', 'post_tags:id,title,id,slug', 'comments:post_id,id,user_id,text'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('is_hide', false)
            ->first();

        if (!$post) {
            abort(404);
        }

        $tags = PostTag::query()
            ->withCount(['posts' => function (Builder $query) {
                $query->where('is_published', '=', true)
                    ->where('is_hide', '=', false);
            }])
            ->get();
        $categories = PostCategory::query()
            ->withCount(['posts' => function (Builder $query) {
                $query->where('is_published', '=', true)
                    ->where('is_hide', '=', false);
            }])
            ->get();

        return view('front.post_show', [
            'post' => $post,
            'tags' => $tags,
            'categories' => $categories
        ]);
    }

    /**
     * Display search page
     * @return void
     */
    public function search()
    {
        $posts = [];

        return view('front.search', [
            'posts' => $posts,
        ]);
    }

    /**
     * Search process
     * @return void
     */
    public function search_process(SearchRequest $searchRequest)
    {
        $search_text = $searchRequest->input('search_text');

        $posts = Post::query()
            ->where('title', 'LIKE', "%{$search_text}%")
            ->orWhere('excerpt', 'LIKE', "%{$search_text}%")
            ->paginate(6);

        return view('front.search', [
            'posts' => $posts,
        ]);
    }
}
