<?php

namespace App\Models\Traits;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasVideos
{
    public static function bootHasVideos()
    {
        static::deleting(function(Model $videoable){
            $videoable->cascadeDeleteRelation(Video::make(), 'videos');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $videoable){
                $videoable->restoreCascadedRelation('videos');
            });
        }
    }


    public function videos():MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
