<?php

namespace App\Models\Traits;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CreatesPosts
{
    public static function bootCreatesPosts()
    {
        static::deleting(function (Model $author) {
            $author->cascadeDeleteRelation(Post::make(), 'createdPosts');
        });
        if (self::canBeSoftDeleted()) {
            static::restored(function (Model $author) {
                $author->restoreCascadedRelation('createdPosts');
            });
        }
    }

    public function createdPosts():HasMany
    {
        $instance = new Post;
        return new HasMany($instance->query(), $instance, 'author_id', 'id');
    }
}
