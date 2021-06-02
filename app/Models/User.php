<?php

namespace App\Models;

use App\Models\Traits\MustVerifyPhone;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\HasDatabaseNotifications;

/**
 * @property ProfileImage profileImage
 * @property Collection<Profile> profiles
 * @property Profile activeProfile
 * @property string lastName
 * @property string firstName
 * @property string public_id
 * @property string phoneNumber
 * @property string email
 * @property \DateTime phone_verified_at
 * @property \DateTime email_verified_at
 *
 *
 * @method static User create(array $array)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasDatabaseNotifications, MustVerifyPhone, ModelTraits, SoftDeletes;


    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::creating(static function(User $account){
            if(empty($account->getAttribute('api_token')))
            {
                // it will be hashed later by the api guard
                $token = Str::random(80);
                if(config('auth.guards.api.hash'))
                    $token = hash('sha256', $token);
                $account->setAttribute('api_token', $token);
            }
        });
    }

    //----- RELATIONS -------//
    public function activeProfile(): HasOne
    {
        return $this->hasOne(Profile::class)->ofMany();
    }
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
    public function settings(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserSettings::class);
    }
    //----- ATTRIBUTES -------//
    public function getFirstNameAttribute()
    {
        return $this->attributes['first_name'];
    }
    public function getLastNameAttribute()
    {
        return $this->attributes['last_name'];
    }
    public function setFirstNameAttribute($new): void
    {
        $this->attributes['first_name'] = $new;
    }
    public function setLastNameAttribute($new): void
    {
        $this->attributes['last_name'] = $new;
    }
    public function getPhoneNumberAttribute()
    {
        return $this->attributes['phone'];
    }
    public function setPhoneNumberAttribute($new): void
    {
        $this->attributes['phone'] = $new;
    }


    //---- HELPERS -----//
    public function isVerified(): bool
    {
        return $this->hasVerifiedPhone() || $this->hasVerifiedEmail();
    }

    public function getEmailForVerification(): string
    {
        return $this->email;
    }
    public function getCodeForVerification(): string
    {
        // now we just take the last 4 characters from the email hash of the user
        $salt = "SHA-2021-03-24-66f4bce05e6af8e4";
        $email = $this->email;
        return strtoupper(substr(hash('sha256', $email . $salt), -4));
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * returns the user's user name or email or phone number (the one that exists)
     * @param string $prefer "email" or "phone"
     * @return string
     */
    public function getUserName($prefer='email')
    {
        if($this->socialProfiles()->count())
        {
            return $this->socialProfiles->first->fullName;
        }
        $this->businessProfile;// loading the magic attribute
        if(isset($this->businessProfile->data->businessOwner->lastName))
        {
            return $this->businessProfile->data->businessOwner->lastName;
        }
        if($prefer === 'email' && !empty($this->email))
        {
            return $this->email;
        }
        if($prefer === 'phone' && !empty($this->phoneNumber))
        {
            return $this->phoneNumber;
        }
        return !empty($this->email) ? $this->email : $this->phoneNumber;
    }

    public function singleUseToken()
    {
        $send = Str::random(80);
        $stored = $send;
        if(config('auth.guards.api.hash'))
        {
            $stored = hash('sha256', $stored);
        }
        $this->update(['api_token' => $stored]);
        return $send;
    }
}
