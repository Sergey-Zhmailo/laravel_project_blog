<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPostCategory
 */
class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description'
    ];

    /**
     * Posts relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
