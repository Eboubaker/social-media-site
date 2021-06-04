<?php

namespace App\Models\Traits;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasVideos
{

    use SoftDeletes;

    
    public function videos():MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public static function bootHasVideos()
    {
        static::deleting(function(Model $videoable){
            assertInTransaction();
            if($videoable->forceDeleting())
            {
                $videoable->videos()->cursor()->each(function(Video $video){
                    $video->forceDelete();
                });
            }else{
                $videoable->videos()->cursor()->each(function (Video $video) {
                    $video->delete();
                });
            }
        });
    }
}
