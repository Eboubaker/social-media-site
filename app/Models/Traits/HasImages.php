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
    public function images():MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public static function bootHasImages()
    {
        static::deleting(function(Model $imageable){
            assertInTransaction();
            if($imageable->forceDeleting())
            {
                $imageable->images()->cursor()->each(function($image){
                    $image->forceDelete();
                });
            }else{
                $imageable->images()->cursor()->each(function ($image) {
                    $image->delete();
                });
            }
        });
    }
}
