<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\Account;
use App\Models\BaseModel;
use App\Models\Comment;
use App\Models\Funcs\ModelFuncs;
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
 * @property Account account
 *
 * @property string create_at
 */
class Profileable extends BaseModel
{
    use HasFactory;
    public $keyType = 'string';
    public $incrementing = false;
    public const PKEY = "uuid";

    public static $morphRelationName = 'profileable';
    protected $guarded = [];

    function __construct(array $attributes = [])
    {
        $this->casts['data'] = JsonObject::class;
        parent::__construct($attributes);

        $handler = app()->get(ModelFuncs::class);
        $HasUuid = $handler->funcs[ModelFuncs::$HasUuid];
        static::creating($HasUuid);
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable', 'postable_type', 'postable_id', Postable::PKEY);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'postable', 'postable_type', 'postable_id', Postable::PKEY);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, Account::FKEY, Account::PKEY, Account::TABLE);
    }
}
