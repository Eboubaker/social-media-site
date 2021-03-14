<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property ProfileImage profileImage
 * @property AccountSettings settings
 * @property BusinessProfile businessProfile
 * @property SocialProfile socialProfile
 * @property string lastName
 * @property string firstName
 * @property string public_id
 *
 */
class Account extends Authenticatable
{
    use HasFactory, Notifiable;

    public const TABLE = "accounts";
    public const PKEY = "id";
    public const PUPLIC_ID_LEN = 8;
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "account_id";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";

    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;

    protected $guarded = [
        self::PKEY
    ];
    protected $fillable = [
        'public_id',
        'first_name',
        'last_name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profileImage()
    {
        return $this->hasOne(ProfileImage::class, self::FKEY, self::PKEY);
    }
    public function settings()
    {
        return $this->hasOne(AccountSettings::class, self::FKEY, self::PKEY);
    }

    public function businessProfile()
    {
        return $this->hasOne(BusinessProfile::class, self::FKEY, self::PKEY);
    }
    public function socialProfile()
    {
        return $this->hasOne(SocialProfile::class, self::FKEY, self::PKEY);
    }

    public function getPublicIdAttribute()
    {
        return $this->attributes['public_id'];
    }

    public function getFirstNameAttribute()
    {
        return $this->attributes['first_name'];
    }
    public function getLastNameAttribute()
    {
        return $this->attributes['last_name'];
    }
    public function setFirstNameAttribute($new)
    {
        $this->attributes['first_name'] = $new;
    }
    public function setLastNameAttribute($new)
    {
        $this->attributes['last_name'] = $new;
    }
}
