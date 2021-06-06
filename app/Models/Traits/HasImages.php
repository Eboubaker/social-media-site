<?php

namespace App\Models\Traits;

use App\Exceptions\NotInTransactionException;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

trait HasImages
{
    public static function bootHasImages()
    {
        static::deleting(function(Model $imageable){
            $imageable->cascadeDeleteRelation(Image::make(), 'images');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $imageable){
                $imageable->restoreCascadedRelation('images');
            });
        }
    }
    public function images():MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
