<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Save post tags while
     * @param array $tags
     * @param $post
     * @return bool
     */
    public function savePostTags(array $tags, $post)
    {
        $add_post_tag = true;
        $clear_post_tags = DB::table('post_post_tags')
            ->where('post_id', '=', $post->id)
            ->delete();

        if (is_array($tags) && count($tags) > 0) {
            foreach ($tags as $tag) {
                $add_post_tag = DB::table('post_post_tags')
                    ->insert([
                        'post_id' => $post->id,
                        'post_tag_id' => $tag
                    ]);
            }
        }

        return $add_post_tag;
    }

    /**
     * Save post image
     * @param $file
     * @param $post
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function savePostImage($file, $post)
    {
        $path = $file->store('posts/' . $post->id, ['disk' => 'public']);

        if ($path) {
            if ($post->image) {
                Storage::delete($post->image);
            }
            $add_image = $post->update(['image' => $path]);
        }

        if (!$add_image) {
            return back()->withErrors(['msg' => 'Update image error']);
        }

        return true;
    }
}
