<?php

namespace App\Models;

use App\Casts\JsonObject;
use App\Models\Morphs\PostableAttachement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Image extends PostableAttachement
{
    use HasFactory;

    public const TABLE = "images";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "image_id";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = null;

    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;
    public static $Storage = 'images';
    public $storage = 'images';
    public static $morphClass = 'App\Models\\' . self::class;

    public static $allowedTypes = [
        [
            'typeId' => 1,
            'mime' => 'image/jpeg',
            'format' => 'jpg'
        ],
        [
            'typeId' => 2,
            'mime' => 'image/jpeg',
            'format' => 'jpeg'
        ],
        [
            'typeId' => 3,
            'mime' => 'image/png',
            'format' => 'png',
        ],
        [
            'typeId' => 4,
            'mime' => 'image/webp',
            'format' => 'webp',
        ]
    ];

    function __construct(array $attributes = [], $pass = false)
    {
        parent::__construct($attributes);
    }


}
