<?php

namespace App\Models;

use App\Models\Traits\CanComment;
use App\Models\Traits\CanFollow;
use App\Models\Traits\CanJoinCommunities;
use App\Models\Traits\CanLike;
use App\Models\Traits\CanView;
use App\Models\Traits\CreatesCommunities;
use App\Models\Traits\CreatesPosts;
use App\Models\Traits\HasFollowers;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasPosts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\HasDatabaseNotifications;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Watson\Validating\ValidatingTrait;

/**
 * @property string lastName
 * @property User $account
 * @property ProfileSettings $settings
 */
class Profile extends Model
{
    use HasFactory, 
    Notifiable, 
    HasDatabaseNotifications, 
    SoftDeletes, 
    ValidatingTrait,
    ModelTraits, 

    CreatesPosts,
    CreatesCommunities,

    HasPosts,
    HasImages,
    HasFollowers,

    CanView,
    CanLike,
    CanComment,
    CanFollow,
    CanJoinCommunities,

    Urlable

    ;
    
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $rules = [
        'username' => ['required', 'unique:profiles,username', 'min:3', 'max:255', 'regex:/^[A-Za-z0-9_]+$/'],
        'user_id' => ['exists:App\Models\User,id']
    ];
    protected $validationMessages = [
        'user_id.exists' => "the linked account does not exist",
        'username.unique' => "Another user is using that username already.",
        'username.regex' => "username may only contain alpha numeric letters and lowdashes(_), no spaces allowed"
    ];
    protected $validationAttributeNames = [
        'user_id' => 'The Account'
    ];
    protected $throwValidationExceptions = true;


    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->setAttribute('active', $attributes['active'] ?? 1);
    }
    public static function boot()
    {
        parent::boot();
        // set other profiles active state to false when a new profile is created.
        static::created(function(Profile $profile){
            $user = $profile->account;
            if($user->profiles()->count() > 1)
            {
                $user->profiles()->where('id', '!=', $profile->getKey())->whereActive(true)->update(["active" => false]);
            }
            $profile->settings()->create();
        });
        // assert only one active profile per account
        static::updating(function(Profile $profile){
            $user = $profile->account;
            if((bool)$profile->active !== (bool)$profile->getOriginal('active') && (bool)$profile->active === true)
            {
                if ($user->profiles()->count() <= 1) 
                {
                    throw new \Exception("attempting to deactivate profile but the user only has one profile");
                }
                $oldActive = $user->profiles()->where('id', '!=', $profile->getKey())->whereActive(true)->first();
                if ( ! is_null($oldActive)) 
                {
                    $oldActive->update(["active" => false]);
                }
            }
        });
    }
    
    #region RELATIONS
    /**
     * Should not be used for creating
     *
     * @return HasMany
     */
    public function communitiesPosts():HasMany
    {
        return $this->createdPosts()->whereHasMorph('pageable', Community::class);
    }
    public function profilePosts():MorphMany
    {
        return $this->posts();
    }
    public function viewedPosts():HasMany
    {
        return $this->views();
    }
    public function replies():HasMany
    {
        return $this->comments()->whereHasMorph('commentable', Comment::class);
    }
    public function account():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function notifications():MorphTo
    {
        return $this->morphTo();
    }
    public function likedPosts()
    {
        return $this->likes()->whereHasMorph('likeable', Post::class);
    }
    public function likedComments()
    {
        return $this->likes()->whereHasMorph('likeable', Comment::class);
    }

    public function profileImage():MorphOne
    {
        return $this->images()->where('purpose', 'profileImage');
    }
    public function coverImage():MorphOne
    {
        return $this->images()->where('purpose', 'coverImage');
    }
    public function communities():BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'communities_members', 'profile_id');
    }
    
    public function settings():HasOne
    {
        return $this->hasOne(ProfileSettings::class);
    }

    #endregion

    /**
     * returns the currently logged-in user's active profile
     *
     * @return Profile|null
     */
    public static function current():Profile|null
    {
        try{
            return Auth::user()->activeProfile;
        }catch(\Throwable $e)
        {
            report($e);
        }
        return null;
    }
    /**
     * returns the id of the currently logged-in user's active profile
     *
     * @return int|null
     */
    public static function current_id():int|null
    {
        try{
            return Auth::user()->activeProfile->id;
        }catch(\Throwable $e)
        {
            report($e);
        }
        return null;
    }

    public function reloadCurrent():void
    {
        Auth::user()->load('activeProfile');
    }
    public function getUrlAttribute(): string
    {
        return route('profile.show', $this->getAttribute('username'));
    }


    public function allows($permission_id, $profile): bool
    {
        if(empty($permission_id) || empty($profile))
            return false;
        if($profile instanceof Profile)
        {
            if( ! $profile->exists)
            {
                return false;
            }
            $profile_id = $profile->getKey();
        }else{
            if( ! Profile::where('id', $profile)->exists())
            {
                return false;
            }
            $profile_id = $profile;
        }
        $he_follow_me = $this->followersModels()->where('follower_id', $profile_id)->exists();
        $i_follow_him = $this->followingsModels()->where('profile_id', $profile_id)->exists();
        $we_are_friends = $he_follow_me && $i_follow_him;

        $settings = $this->settings;
        if($permission_id === config('permissions.profiles.can-comment'))
        {
            if($settings->allow_non_followers_to_comment_on_my_profile_posts)
            {
                return true;
            }
            if($he_follow_me && $settings->allow_followers_to_comment_on_my_profile_posts)
            {
                return true;
            }
            if($i_follow_him && $settings->allow_followings_to_comment_on_my_profile_posts)
            {
                return true;
            }
            if($we_are_friends && $settings->allow_friends_to_comment_on_my_profile_posts)
            {
                return true;
            }
        }else if($permission_id === config('permissions.profiles.can-view-posts'))
        {
            if($settings->allow_non_followers_to_view_my_profile_posts)
            {
                return true;
            }
            if($he_follow_me && $settings->allow_followers_to_view_my_profile_posts)
            {
                return true;
            }
            if($i_follow_him && $settings->allow_followings_to_view_my_profile_posts)
            {
                return true;
            }
            if($we_are_friends && $settings->allow_friends_to_view_my_profile_posts)
            {
                return true;
            }
        }else if($permission_id === config('permissions.profiles.can-follow'))
        {
            if($settings->allow_others_to_follow_me)
            {
                return true;
            }
            if($i_follow_him && $settings->allow_followings_to_follow_me_back)
            {
                return true;
            }
        }
        return false;
    }
    /**
     * 
     * Does this community allow this action for the current profile?
     * 
     * @param int $permission_id if of the permission
     * @return true if this community allows the action for the current profile 
     * @return false if this community does not allow the current profile to do the action
     */
    public function allowsCurrent(int $permission_id): bool
    {
        return $this->allows($permission_id, Profile::current_id());
    }
}
