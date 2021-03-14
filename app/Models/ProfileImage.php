<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mockery\Exception;

class ProfileImage extends Image
{
    use HasFactory;

    public const TABLE = "profile_images";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public static $Storage = 'profile_images';
    public $storage = 'profile_images';
    protected $table = self::TABLE;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|void
     * @deprecated profile images does not have a postable
     */
    public function postable()
    {
        throw new Exception("Does not have Postable");
    }
}
