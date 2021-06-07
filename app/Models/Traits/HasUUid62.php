<?php

namespace App\Models\Traits;

use App\Exceptions\NotInTransactionException;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait HasUUid62
{
    public static function bootHasUUid62()
    {
        static::creating(function(Model $model){
            if(empty($model->attributes['uuid62']))
            {
                $remaining_attempts = 2;
                do{
                    $uuid62 = Str::random(6);
                    $remaining_attempts--;
                }while($model::where('uuid62', $uuid62)->exists() && $remaining_attempts > 0);
                $model->setAttribute('uuid62', $uuid62);
            }
        });
    }
}
