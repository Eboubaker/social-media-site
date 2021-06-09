<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PostView
 *
 * @property int $id
 * @property int $viewer_id
 * @property int $post_id
 * @property \Illuminate\Support\Carbon|null $viewed_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read mixed $created
 * @property-read \App\Models\Post|null $post
 * @property-read \App\Models\Profile $viewer
 * @method static \Illuminate\Database\Eloquent\Builder|PostView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostView newQuery()
 * @method static \Illuminate\Database\Query\Builder|PostView onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostView query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereReasonDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereViewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereViewerId($value)
 * @method static \Illuminate\Database\Query\Builder|PostView withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PostView withoutTrashed()
 * @mixin \Eloquent
 */
class PostView extends Model
{
    use HasFactory,
    SoftDeletes,
    ModelTraits;

    public const CREATED_AT = 'viewed_at';
    public const UPDATED_AT = null;

    protected $guarded = [];

    public function viewer()
    {
        return $this->belongsTo(Profile::class, 'viewer_id');
    }
    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
