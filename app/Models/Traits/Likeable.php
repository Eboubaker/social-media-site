<?php


namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likeable
{
    public static function bootLikeable()
    {
        static::deleting(function(Model $likeable){
            assertInTransaction();
            if($likeable->forceDeleting())
            {
                $likeable->likes()->delete();
            }
        });
    }
    public function likes():MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
