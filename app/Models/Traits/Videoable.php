<?php

namespace App\Models\Traits;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

trait Videoable
{
    use SoftDeletes;

    public function video():MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }

    public static function bootVideoable()
    {
        static::deleting(function(Model $videoable){
            assertInTransaction();
            if($videoable->video()->exists())
            {
                if($videoable->isForceDeleting())
                {
                    $videoable->video->forceDelete();
                }else{
                    $videoable->video->delete();
                };
            }
        });
    }
}
