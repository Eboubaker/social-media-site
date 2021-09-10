<?php

namespace App\Models;

use App\DataBase\Eloquent\HasMany;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\User
 *
 * @property Collection<Profile> profiles
 * @property Profile activeProfile
 * @property string lastName
 * @property string firstName
 * @property string public_id
 * @property string phoneNumber
 * @property string email
 * @property \DateTime phone_verified_at
 * @property \DateTime email_verified_at
 * @method static User create(array $array)
 * @property int $id
 * @property string|null $email
 * @property string|null $phone
 * @property string $first_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $api_token
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read \App\Models\Profile|null $activeProfile
 * @property-read mixed $created
 * @property mixed $phone_number
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @property-read int|null $profiles_count
 * @property-read \App\Models\UserSettings|null $settings
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReasonDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
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
    protected $with = [];




    public static function boot()
    {
        parent::boot();
        static::created(function (User $user) {
            $user->settings()->create();
        });
    }
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
        $stored = config('auth.guards.api.hash') ? hash('sha256', $send) : $send;
        $this->forceFill(['api_token' => $stored])->save();
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
        if ($profile instanceof Profile) {
            $profile_id = $profile->getKey();
        } else {
            $profile_id = $profile;
        }
        return DB::table('profiles')->where('id', $profile_id)->where('user_id', $this->getKey())->exists();
    }


    public function allCreatedPosts(): Builder
    {
        return Post::query()->whereIn('author_id', $this->profiles()->select('id'));
    }
}
