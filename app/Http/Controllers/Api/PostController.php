<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Return all posts
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
//        dd(explode(',', \request()->get('tag_id')));
//        return PostResource::collection(\Cache::remember('posts', 60*60*24, function () {
//            return Post::with(['post_category', 'post_tags', 'comments'])->get();
//        }));
        return PostResource::collection(Post::with(['post_category', 'post_tags', 'comments'])
            ->when($request->filled('tag_id'), function ($query) {
                $query->whereHas('post_tags', function ($q) {
                    $q->whereIn('id', explode(',', \request()->get('tag_id')));
                });
            })
            ->when($request->filled('cat_id'), function ($query) {
                $query->whereHas('post_category', function ($q) {
                    $q->where('id', '=', \request()->get('cat_id'));
                });
            })
            ->when($request->filled('search'), function ($query) {
                $query->where('title', 'like', '%' . \request()->get('search') . '%');
            })
            ->paginate());
    }

    public function show($id)
    {
        return PostResource::make(Post::with(['post_category', 'post_tags', 'comments'])->findOrFail($id));
    }
}
