<?php


namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likeable
{
    public function likes():MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function bootHasLikes()
    {
        static::deleting(function(Model $likeable){
            assertInTransaction();
            $likeable->likes()->delete();
        });
    }
}
