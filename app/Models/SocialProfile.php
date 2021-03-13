<?php

namespace App\Models;

use App\Models\Morphs\Profileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialProfile extends Profileable
{
    use HasFactory;

    public const TABLE = "social_profiles";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "social_profile_id";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";

    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;

    protected $guarded = [
        self::PKEY
    ];
    protected $hidden = [];
    protected $casts = [
        'data' => 'object'
    ];
}
