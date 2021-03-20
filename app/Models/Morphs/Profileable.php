<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\User;
use App\Models\BaseModel;
use App\Models\Comment;
use App\Models\Events\ModelEvents;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Collection\Collection;

/**
 * @property Collection posts
 * @property Collection comments
 * @property User account
 *
 * @property string create_at
 */
class Profileable extends BaseModel
{
    use HasFactory;
    public const PKEY = "id";
    protected $primaryKey = self::PKEY;
    protected $guarded = [];

    function __construct(array $attributes = [])
    {
        $this->casts['data'] = JsonObject::class;
        parent::__construct($attributes);
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'profileable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'profileable');
    }

    public function account()
    {
        return $this->belongsTo(User::class);
    }
}
