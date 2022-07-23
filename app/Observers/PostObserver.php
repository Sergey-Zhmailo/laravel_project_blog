<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function creating(Post $post)
    {
        $this->setPublishedAt($post);
        $this->setSlug($post);
        $this->setUser($post);
    }

    /**
     * Handle the Post "updating" event.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function updating(Post $post)
    {
        $this->setPublishedAt($post);
        $this->setSlug($post);
    }

    /**
     * Set published_at field
     * @param Post $post
     * @return void
     */
    protected function setPublishedAt(Post $post)
    {
        if (empty($post->published_at) && $post->is_published) {
            $post->published_at = Carbon::now();
        }
    }

    /**
     * Set slug field
     * @param Post $post
     * @return void
     */
    protected function setSlug(Post $post)
    {
        if (empty($post->slug)) {
            $post->slug = Str::slug($post->title);
        }
    }

    /**
     * Set user_id field
     * @param Post $post
     * @return void
     */
    protected function setUser(Post $post)
    {
        $post->user_id = auth('web')->id();
    }
}
