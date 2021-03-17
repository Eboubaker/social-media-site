<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\BaseModel;
use App\Models\Comment;
use App\Models\Events\ModelEvents;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Postable extends BaseModel
{
    use HasFactory, Commentable;
    public const PKEY = 'id';
    protected $primaryKey = self::PKEY;
    protected $guarded = [];
    // TODO: remove this in production
    protected $fillable = ['id','content', 'public_id', 'profileable_type', 'profileable_id', 'created_at', 'updated_at'];
    // TODO: in production mode check for unnecessary eager loaded relations, exclude them using $model->without(...)
    protected $with = ['comments', 'videos', 'images', 'profileable'];

    function __construct(array $attributes = [], $pass = false)
    {
        $this->casts['content'] = JsonObject::class;
        parent::__construct($attributes);
    }
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'postable');
    }
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'postable');
    }
    public function postable(): MorphTo
    {
        return $this->morphTo('postable');
    }
    public function profileable(): MorphTo
    {
        return $this->morphTo('profileable');
    }
}
