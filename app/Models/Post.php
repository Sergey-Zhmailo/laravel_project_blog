<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    /**
     * User relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Post category relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post_category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id', 'id');
    }

    /**
     * Post tags relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function post_tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_post_tags', 'post_id', 'post_tag_id', 'id', 'id');
    }

    /**
     * Comments relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at');
    }

    /**
     * Add media types
     * @param Media|null $media
     * @return void
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('post_preview')
            ->width(1080)
            ->height(450)
            ->sharpen(10)
            ->crop('crop-center', 1080, 450);

        $this->addMediaConversion('post_thumb')
            ->width(300)
            ->height(300)
            ->crop('crop-center', 300, 300);
    }
}
