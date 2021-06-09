<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Follow
 *
 * @property int $profile_id
 * @property int $follower_id
 * @property Profile $follower
 * @property Profile $following
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read mixed $created
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newQuery()
 * @method static \Illuminate\Database\Query\Builder|Follow onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereReasonDeleted($value)
 * @method static \Illuminate\Database\Query\Builder|Follow withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Follow withoutTrashed()
 * @mixin \Eloquent
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
