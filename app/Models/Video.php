<?php

namespace App\Models;

use App\Models\Funcs\ModelFuncs;
use App\Models\Morphs\PostableAttachement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;

class Video extends PostableAttachement
{
    use HasFactory;

    public const TABLE = "videos";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "video_id";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = null;
    public static $morphClass = 'App\Models\\' . self::class;

    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;
    public static $Storage = 'videos';
    public $storage = 'videos';
    public $allowedTypes = [
        0 => [
            'fileSuffix' => 'mp4',
            'signature' => ["00","00","00","20","66","74","79","70","69","73","6F","6D"]
        ],
    ];
    public static function getAllowedTypes(): Collection
    {
        return collect((new self)->allowedTypes);
    }

}
