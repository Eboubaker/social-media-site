<?php

namespace App\Models\Traits;

use App\Models\Video;
use App\DataBase\Eloquent\MorphMany as CustomMorphMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasVideos
{
    public static function bootHasVideos()
    {
        static::deleting(function(Model $videoable){
            if ($videoable->videos()->count()>0) {
                $videoable->cascadeDeleteRelation(Video::make(), 'videos');
            }
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $videoable){
                $videoable->restoreCascadedRelation('videos');
            });
        }
    }


    public function videos():CustomMorphMany
    {
        return (new CustomMorphMany(Video::query(), $this, 'videoable_type', 'videoable_id', 'id'));
    }
}
