<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostTagController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $tag = PostTag::with('posts')
            ->where('slug', $slug)
            ->first();

        if (!$tag) {
            return redirect('404');
        }

        $posts = $tag->posts()
            ->where('is_published', true)
            ->where('is_hide', false)
            ->where('published_at', '<', Carbon::now())
            ->paginate(6);

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

        return view('front.tag_show', [
            'tag' => $tag,
            'tags' => $tags,
            'categories' => $categories,
            'posts' => $posts
        ]);
    }
}
