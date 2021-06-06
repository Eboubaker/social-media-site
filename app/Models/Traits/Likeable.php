<?php


namespace App\Models\Traits;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likeable
{
    public static function bootLikeable()
    {
        static::deleting(function(Model $likeable){
            $likeable->cascadeDeleteRelation(Like::make(), 'likes');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $likeable){
                $likeable->restoreCascadedRelation('likes');
            });
        }
    }
    public function likes():MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
