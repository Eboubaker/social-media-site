<?php

namespace App\Models\Traits;

use App\Exceptions\NotInTransactionException;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

trait HasImages
{
    public function images():MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function bootHasImages()
    {
        static::deleting(function(Model $imageable){
            assertInTransaction();
            $imageable->images->cursor()->each(function(Image $image){
                $image->delete();
            });
        });
    }
}
