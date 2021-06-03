<?php

namespace App\Models;

use App\Exceptions\NotInTransactionException;
use App\Models\Traits\HasApiToken;
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
use Illuminate\Support\Facades\DB;

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
    use HasFactory, 
    Notifiable, 
    HasDatabaseNotifications, 
    MustVerifyPhone,
    ModelTraits,
    HasApiToken;


    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];
    
    public function bootHasProfiles()
    {
        static::deleting(function(User $user){
            assertInTransaction();
            $user->profiles()->cursor()->each(fn($profile) => $profile->forceDelete());
        });
    }

    //----- RELATIONS -------//
    public function activeProfile(): HasOne
    {
        return $this->hasOne(Profile::class)->ofMany(relation:function($query){
            $query->where('active', true);
        });
    }
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
    public function settings(): HasOne
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
        return $this->getAttribute('first_name');
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
    /**
     * returns weather this user owns this profile or not.
     *
     * @param Profile|int $profile
     * @return bool
     */
    public function owns($profile)
    {
        if($profile instanceof Profile)
        {
            $profile_id = $profile->getKey();
        }else{
            $profile_id = $profile;
        }
        return $this->profiles()->whereId($profile_id)->exists();
    }
}
