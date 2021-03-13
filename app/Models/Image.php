<?php

namespace App\Models;

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

    public $allowedTypes = [
        0 => [
            'fileSuffix' => 'png',
            'signature' => ['89','50','4E','47','0D','0A','1A','0A']
        ],
        1 => [
            'fileSuffix' => 'jpg',
            'signature' => ['FF','D8','FF']
        ]
    ];


    public static function getAllowedTypes(): Collection
    {
        return collect((new self)->allowedTypes);
    }

}
