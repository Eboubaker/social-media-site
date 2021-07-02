<?php

namespace App\Models\Traits;

use App\DataBase\Eloquent\MorphMany as CustomMorphMany;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

trait HasImages
{
    public static function bootHasImages()
    {
        static::deleting(function(Model $imageable){
            if ($imageable->images()->count()>0) {
                $imageable->cascadeDeleteRelation(Image::make(), 'images');
            }
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $imageable){
                $imageable->restoreCascadedRelation('images');
            });
        }
    }
    public function images():CustomMorphMany
    {
        return (new CustomMorphMany(Image::query(), $this, 'imageable_type', 'imageable_id', 'id'));
    }
}
