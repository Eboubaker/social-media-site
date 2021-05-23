<?php

namespace App\Models\Traits;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPosts
{
    public function posts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }
}