<?php

namespace App\Models;

use App\Models\Morphs\Postable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Postable
{
    use HasFactory;

    public const TABLE = "posts";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "post_id";
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


}
