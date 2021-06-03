<?php

namespace App\Models\Traits;

use App\Exceptions\NotInTransactionException;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

trait HasVideos
{
    public function videos():MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function bootHasVideos()
    {
        static::deleting(function(Model $videoable){
            assertInTransaction();
            $videoable->videos->cursor()->each(function(Video $video){
                $video->delete();
            });
        });
    }
}
