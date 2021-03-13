<?php

namespace App\Models;

use App\Models\Morphs\Commentable;
use App\Models\Morphs\Postable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Postable
{
    use HasFactory;

    public const TABLE = "comments";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "comment_id";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";


    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;

    protected $guarded = [
        self::PKEY
    ];

    public function __construct(array $attributes = [], $pass = false)
    {
        parent::__construct($attributes, $pass);
    }

    public function comments()
    {
        $morphicName = Commentable::$morphRelationName;
        return $this->morphedByMany(self::class,
            $morphicName,
            Commentable::TABLE,
            $morphicName.'_id',
            self::FKEY,
            self::PKEY, self::PKEY);
    }
}
