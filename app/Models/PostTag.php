<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPostTag
 */
class PostTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description'
    ];

    public function posts() {
        {
            return $this->belongsToMany(Post::class, 'post_post_tags', 'post_tag_id', 'post_id', 'id', 'id');
        }
    }
}
