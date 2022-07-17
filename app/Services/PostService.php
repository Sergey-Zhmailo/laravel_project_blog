<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function getAllWithPaginate($perPage = null)
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
            ->where([
                ['is_published', '=', 'true'],
                ['is_hide', '=', 'false'],

            ])
            ->paginate($perPage);

        return $posts;
    }
}
