<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileData extends Model
{
    use HasFactory;
    
    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    public const DELETED_AT = null;

    public static function boot()
    {
        parent::boot();
        static::saving(function (ProfileData $data) {
            if (empty($data->website_url)) {
                $data->website_url = $data->profile->name;
            }
        });
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
