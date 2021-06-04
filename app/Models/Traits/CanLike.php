<?php


namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CanLike
{
    public function likes():MorphMany
    {
        return $this->hasMany(Like::class, 'liker_id');
    }

    public static function bootCanLike()
    {
        static::deleting(function(Model $liker){
            assertInTransaction();
            if($liker->forceDeleting())
            {
                $liker->likes()->delete();
            }
        });
    }
}
