<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
//        $tag = PostTag::with('posts:id,id,title,slug,image,published_at')
//            ->where('slug', $slug)
//            ->first();

        $tag = PostTag::with('posts')
            ->where('slug', $slug)
            ->first();

        if (!$tag) {
            return redirect('404');
        }

        $posts = $tag->posts()
            ->where('is_published', true)
            ->where('is_hide', false)
            ->paginate(6);

        $tags = PostTag::with('posts')->get(['id', 'title', 'slug']);
        $categories = PostCategory::with('posts')->get(['id', 'title', 'slug']);

        return view('front.tag_show', [
            'tag' => $tag,
            'tags' => $tags,
            'categories' => $categories,
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
