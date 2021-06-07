<?php

namespace App\Models;

use App\Models\Traits\HasApiToken;
use App\Models\Traits\HasProfiles;
use App\Models\Traits\MustVerifyPhone;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property Image profileImage
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
    SoftDeletes,

    ModelTraits,
    HasApiToken,
    HasProfiles;


    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['activeProfile'];

    //----- RELATIONS -------//
    public function activeProfile(): HasOne
    {
        return $this->hasOne(Profile::class)->where('active', true);
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
        return $this->hasVerifiedEmail() || $this->hasVerifiedPhone();
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
    public function getUserName()
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
        return DB::table('profiles')->where('id', $profile_id)->where('user_id', $this->getKey())->exists();
    }
}
