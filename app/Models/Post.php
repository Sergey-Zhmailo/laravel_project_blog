<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'tag_ids',
        'slug',
        'title',
        'image',
        'excerpt',
        'content',
        'is_published',
        'is_hide',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post_category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id', 'id');
    }

    public function post_tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_post_tags', 'post_id', 'post_tag_id', 'id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at');
    }
}
