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
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Comment|Post $commentable
 * @property Comment|Post $ancestor_commentable
 * @property Comment|Post $ancestorCommentable
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


    protected $rules = [
        'commentor_id' => ['exists:App\Models\Profile,id'],
        'body' => ['required', 'max:2048'],
    ];
    protected $validationMessages = [
        'commentor_id.exists' => "comment author not found.",
    ];
    protected $validationAttributeNames = [
        'commentable_id' => 'comment location'
    ];
    protected $throwValidationExceptions = true;

    public function __construct($atts=[])
    {
        parent::__construct($atts);
        $this->rules['commentable_id'][] = new PolymorphicRelationExists($this, 'commentable');
    }

    private $anc_commentable = false;

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function commentor()
    {
        return $this->belongsTo(Profile::class, 'commentor_id');
    }

    public function getAncestorCommentableAttribute(): Post
    {
        if($this->anc_commentable === false)
        {
            $nestingLevel = 10;
            $commentable = $this->commentable;
            while($nestingLevel-- > 0 && $commentable instanceof Comment)
            {
                $commentable = $commentable->commentable;
            }
            $this->anc_commentable = $commentable;
        }
        return $this->anc_commentable;
    }

    public function getUrlAttribute(): string
    {
        $post = $this->ancestor_commentable;
        if($post->pageable instanceof Community)
        {
            return route('community.posts.comments.show', [$post->pageable->name, $post->uuid62, $this->uuid62]);
        }else if($post->pageable instanceof Profile)
        {
            return route('profile.posts.comments.show', [$post->pageable->username, $post->uuid62, $this->uuid62]);
        }
    }
}
