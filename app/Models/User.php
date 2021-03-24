<?php

namespace App\Models;

use App\Models\Traits\MustVerifyPhone;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @property ProfileImage profileImage
 * @property UserSettings settings
 * @property BusinessProfile businessProfile
 * @property SocialProfile socialProfile
 * @property string lastName
 * @property string firstName
 * @property string public_id
 * @property string phoneNumber
 * @property string email
 *
 * @method static User create(array $array)
 */
class User extends Authenticatable implements MustVerifyEmail, MustVerifyPhone
{
    use HasFactory, Notifiable, MustVerifyPhone;

    public const TABLE = "users";
    public const PKEY = "id";
    public const PUPLIC_ID_LEN = 8;
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "user_id";
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


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::creating(static function(User $account){
            $account->setAttribute('api_token', hash('sha256', Str::random(32)));
        });
    }

    public function settings()
    {
        return $this->hasOne(UserSettings::class);
    }

    public function businessProfile()
    {
        return $this->hasOne(BusinessProfile::class);
    }
    public function socialProfile()
    {
        return $this->hasOne(SocialProfile::class);
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
    public function activeProfile()
    {
        return $this->morphTo('active_profileable');
    }
}
