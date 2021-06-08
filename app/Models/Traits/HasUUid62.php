<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string $uuid62
 */
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
