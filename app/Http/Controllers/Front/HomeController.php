<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPublicWithPaginate(6);
        $tags = PostTag::all('id', 'title', 'slug');
        $categories = PostCategory::all('id', 'title', 'slug');

        return view('front.home', [
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories
        ]);
    }

    public function show($slug)
    {
        $post = Post::with(['post_category:id,title,id,slug', 'post_tags:id,title,id,slug', 'comments:post_id,id,user_id,text'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('is_hide', false)
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
}
