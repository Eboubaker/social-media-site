<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\Comment;
use App\Models\Funcs\ModelFuncs;
use App\Models\Image;
use App\Models\SocialProfile;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Postable extends Commentable
{
    use HasFactory;
    public static $morphRelationName = 'postable';
    protected $with = ['comments', 'videos', 'images'];

    function __construct(array $attributes = [], $pass = false)
    {
        $this->casts['content'] = JsonObject::class;
        parent::__construct($attributes);

        if(!$pass) {
            $handler = app()->make(ModelFuncs::class);
            $HasUuid = $handler->funcs[ModelFuncs::$HasUuid];

            static::creating($HasUuid);
        }

    }

    public function videos()
    {
        return $this->morphMany(Video::class, self::$morphRelationName, null, null, self::PKEY);
    }
    public function images()
    {
        return $this->morphMany(Image::class, self::$morphRelationName, null, null, self::PKEY);
    }
    public function comments()
    {
        $morphicName = Commentable::$morphRelationName;
        return $this->morphToMany(Comment::class,
            $morphicName,
            Commentable::TABLE,
            $morphicName.'_id',
            Comment::FKEY,
            self::PKEY, Comment::PKEY);
    }
}
