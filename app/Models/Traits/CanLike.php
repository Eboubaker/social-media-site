<?php


namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

trait CanLike
{
    public static function bootCanLike()
    {
        static::deleting(function(Model $liker){
            $liker->cascadeDeleteRelation(Like::make(), 'likes');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $liker){
                $liker->restoreCascadedRelation('likes');
            });
        }
    }

    public function likes():HasMany
    {
        return $this->hasMany(Like::class, 'liker_id');
    }
}
