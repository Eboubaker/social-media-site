<?php


namespace App\Models\Traits;

use App\DataBase\Eloquent\HasMany;
use App\Models\Like;
use Illuminate\Database\Eloquent\Model;

trait CanLike
{
    public static function bootCanLike()
    {
        static::deleting(function (Model $liker) {
            $liker->cascadeDeleteRelation(Like::make(), 'likes');
        });
        if (self::canBeSoftDeleted()) {
            static::restored(function (Model $liker) {
                $liker->restoreCascadedRelation('likes');
            });
        }
    }

    public function likes():HasMany
    {
        $instance = new Like;
        return new HasMany($instance->query(), $instance, 'liker_id', 'id');
    }
}
