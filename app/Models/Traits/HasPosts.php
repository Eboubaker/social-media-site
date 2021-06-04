<?php

namespace App\Models\Traits;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPosts
{
    public function posts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }

    public static function bootHasPosts()
    {
        static::deleting(function(Model $pageable){
            assertInTransaction();
            $pageable->posts()->cursor()->each(function(Post $post){
                $post->forceDelete();
            });
        });
    }
}