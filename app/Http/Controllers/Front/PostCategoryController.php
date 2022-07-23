<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostCategoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $category = PostCategory::with('posts')
            ->where('slug', $slug)
            ->first();

        if (!$category) {
            return redirect('404');
        }
        $posts = $category->posts()
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

        return view('front.category_show', [
            'category' => $category,
            'tags' => $tags,
            'categories' => $categories,
            'posts' => $posts
        ]);
    }
}
