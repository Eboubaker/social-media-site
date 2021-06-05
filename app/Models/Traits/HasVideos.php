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
            assertInTransaction();
            if($videoable->forceDeleting())
            {
                $videoable->videos()->cursor()->each(function(Video $video){
                    $video->forceDelete();
                });
            }elseif(Video::canBeForceDeleted())
            {
                // $videoable->videos()->cursor()->each(function (Video $video) {
                //     $video->delete();
                // });
                $videoable->videos()->update(["deleted_at" => now()]);
            }
        });
    }


    public function videos():MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
