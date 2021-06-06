<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $profile_id
 * @property int $follower_id
 * @property Profile $follower
 * @property Profile $following
 */
class Follow extends Model
{
    use ModelTraits, 
    AsPivot, 
    SoftDeletes;

    protected $table = 'profiles_followers';
    protected $guarded = [];

    public const CREATED_AT = null;
    public const UPDATED_AT = null;


    public function follower():BelongsTo
    {
        return $this->belongsTo(Profile::class, 'follower_id');
    }
    public function following():BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
