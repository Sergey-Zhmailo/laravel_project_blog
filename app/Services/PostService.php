<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Carbon;

class PostService
{
    /**
     * Get post fo all users, is published, not hide with pagination
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllPublicWithPaginate(int $perPage = null)
    {
        $columns = [
            'id',
            'category_id',
            'slug',
            'title',
            'image',
            'excerpt',
            'published_at'
        ];

        $posts = Post::query()
            ->select($columns)
            ->with(['post_category:id,title,id,slug', 'post_tags:id,title,id,slug', 'comments:post_id,id,user_id,text'])
            ->withCount([
                'comments'
            ])
            ->where('is_published', '=', true)
            ->where('is_hide', '=', false)
            ->where('published_at', '<', Carbon::now())
            ->paginate($perPage);

        return $posts;
    }

    /**
     * Get posts by logged user with pagination
     * @param $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllUserWithPaginate($perPage = null)
    {
        $columns = [
            'id',
            'category_id',
            'slug',
            'title',
            'image',
            'excerpt',
            'published_at',
            'is_published'
        ];
        $user_id = auth('web')->id();
        $posts = Post::query()
            ->select($columns)
            ->with(['post_category:id,title,id,slug', 'post_tags:id,title,id,slug', 'comments:post_id,id,user_id,text'])
            ->where('user_id', '=', $user_id)
            ->paginate($perPage);

        return $posts;
    }
}
