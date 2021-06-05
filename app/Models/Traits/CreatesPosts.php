<?php

namespace App\Models\Traits;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CreatesPosts
{
    public static function bootCreatesPosts()
    {
        static::deleting(function($author){
            assertInTransaction();
            if($author->forceDeleting())
            {
                $author->createdPosts()->cursor()->each(function(Post $post){
                    $post->forceDelete();
                });
            }
        });
    }

    public function createdPosts():HasMany
    {
        return $this->HasMany(Post::class, 'author_id');
    }
}