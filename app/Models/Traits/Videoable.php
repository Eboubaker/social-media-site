<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Videoable
{
    public function videos():MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
