<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Notifications\PostCreated;
use App\Notifications\PostPublished;
use App\Notifications\PostUpdated;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
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

    public function created(Post $post)
    {
        // Add notification
        $admins = User::where('role_id', '=', Role::IS_ADMIN)->get();
        if ($post->is_published) {

            Notification::send($admins, new PostPublished($post));
        }
//        $admins->each(function (User $user) use($post) {
//            $user->notify(new PostCreated($post));
//        });
        Notification::send($admins, new PostCreated($post));

        Cache::forget('posts');
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

    public function updated(Post $post)
    {
        // Add notification
//        $admins = User::where('role_id', '=', Role::IS_ADMIN)->get();
//        Notification::send($admins, new PostUpdated($post));

        if ($post->is_published) {
            // Add notification
            $admins = User::where('role_id', '=', Role::IS_ADMIN)->get();
            Notification::send($admins, new PostPublished($post));
        }

        logs()->debug('post update');
        Log::error('asdas');
    }

    /**
     * Handle the Post "deleting" event.
     * @param Post $post
     * @return void
     */
    public function deleting(Post $post)
    {
//        dd(__METHOD__, $post);
    }

    /**
     * Handle the Post "deleted" event.
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
//        dd(__METHOD__, $post);
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
