<?php

namespace App\Models\Traits;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPosts
{
    public static function bootHasPosts()
    {
        static::deleting(function(Model $pageable){
            assertInTransaction();
            if($pageable->forceDeleting())
            {
                $pageable->posts()->cursor()->each(function(Post $post){
                    $post->forceDelete();
                });
            }
        });
    }
    public function posts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }
}