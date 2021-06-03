<?php

namespace App\Models\Traits;

use App\Exceptions\NotInTransactionException;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;

trait Imageable
{
    public function image():MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function bootImageable()
    {
        static::deleting(function(Model $imageable){
            assertInTransaction();
            if($imageable->image()->exists())
            {
                $imageable->image->delete();
            }
        });
    }
    
}
