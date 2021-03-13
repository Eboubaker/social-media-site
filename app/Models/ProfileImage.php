<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfileImage extends Image
{
    use HasFactory;

    public const TABLE = "profile_images";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public static $Storage = 'profile_images';
    public $storage = 'profile_images';
    protected $table = self::TABLE;
}
