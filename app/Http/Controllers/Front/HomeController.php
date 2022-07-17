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
        $posts = $this->postService->getAllWithPaginate(12);
        $tags = PostTag::all('id', 'title', 'slug');
        $categories = PostCategory::all('id', 'title', 'slug');

        return view('front.home', [
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories
        ]);
    }
}
