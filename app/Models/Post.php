<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
