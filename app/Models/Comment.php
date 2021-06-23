<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasUUid62;
use App\Models\Traits\HasVideos;
use App\Models\Traits\Imageable;
use App\Models\Traits\Likeable;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use App\Rules\PolymorphicRelationExists;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Comment
 *
 * @property Comment|Post $commentable
 * @property Post $post
 * @property int $id
 * @property string $uuid62
 * @property int $commentor_id
 * @property string $commentable_type
 * @property int $commentable_id
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read \App\Models\Profile $commentor
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read mixed $created
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read int|null $videos_count
 * @method static self make($parameters)
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereReasonDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUuid62($value)
 * @method static \Illuminate\Database\Query\Builder|Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comment withoutTrashed()
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use HasFactory, 
    SoftDeletes,

    ModelTraits,
    HasUUid62,
    HasImages,
    HasVideos,
    Commentable,
    Likeable,
    Urlable;

    
    public $table = 'comments';
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";
    protected $guarded = [];
    protected $with = [];

    public function replies()
    {
        return $this->comments()->withFixedConstraint('post_id', $this->post_id, false);
    }
    public function commentor()
    {
        return $this->belongsTo(Profile::class, 'commentor_id');
    }
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
    public function getUrlAttribute(): string
    {
        $post = $this->post;
        if($post->pageable instanceof Community)
        {
            return route('community.posts.comments.show', [$post->pageable->name, $post->uuid62, $this->uuid62]);
        }else if($post->pageable instanceof Profile)
        {
            return route('profile.posts.comments.show', [$post->pageable->username, $post->uuid62, $this->uuid62]);
        }
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
