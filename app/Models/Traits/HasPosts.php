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
            $pageable->cascadeDeleteRelation(Post::make(), 'posts');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $pageable){
                $pageable->restoreCascadedRelation('posts');
            });
        }
    }

    public function posts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }
}
