<?php

namespace App\Models\Traits;

use App\Exceptions\NotInTransactionException;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

trait Imageable
{
    use SoftDeletes;

    public function image():MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public static function bootImageable()
    {
        static::deleting(function(Model $imageable){
            assertInTransaction();
            if($imageable->image()->exists())
            {
                if($imageable->isForceDeleting())
                {
                    $imageable->image->forceDelete();
                }else{
                    $imageable->image->delete();
                };
            }
        });
    }
    
}
