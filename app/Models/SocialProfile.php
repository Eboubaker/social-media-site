<?php

namespace App\Models;

use App\Casts\JsonObject;
use App\Models\Morphs\Profileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string lastName
 */
class SocialProfile extends Profileable
{
    use HasFactory;

    public const TABLE = "social_profiles";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "social_profile_id";


    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;


    public function profileImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'profileable');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }
}
