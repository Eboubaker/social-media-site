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
            assertInTransaction();
            if($imageable->forceDeleting())
            {
                $imageable->images()->cursor()->each(function($image){
                    $image->forceDelete();
                });
            }else if(Image::canBeForceDeleted())
            {
                // $imageable->images()->cursor()->each(function ($image) {
                //     $image->delete();
                // });
                $imageable->images()->update(["deleted_at" => now()]);
            }
        });
    }
    public function images():MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
