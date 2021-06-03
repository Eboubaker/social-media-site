<?php

namespace App\Models\Traits;

use App\Exceptions\NotInTransactionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;

trait Videoable
{
    public function video():MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }

    public function bootVideoable()
    {
        static::deleting(function(Model $videoable){
            assertInTransaction();
            if($videoable->video()->exists())
            {
                $videoable->video->delete();
            }
        });
    }
}
