<?php

namespace App\Models;

use App\Models\Traits\CanFollow;
use App\Models\Traits\CanLike;
use App\Models\Traits\CanView;
use App\Models\Traits\CreatesPosts;
use App\Models\Traits\HasFollowers;
use App\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\HasDatabaseNotifications;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Watson\Validating\ValidatingTrait;

/**
 * @property string lastName
 * @property User $account
 */
class Profile extends Model
{
    use HasFactory, 
    Notifiable, 
    HasDatabaseNotifications, 
    ModelTraits, 
    SoftDeletes, 
    Urlable,
    ValidatingTrait,
    HasImages,
    CreatesPosts,
    CanView,
    CanLike,
    HasFollowers,
    CanFollow;
    
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $rules = [
        'username' => ['required', 'unique:profiles,username', 'min:3', 'max:255', 'regex:/^[A-Za-z0-9_]+$/']
    ];
    protected $validationMessages = [
        'username.unique' => "Another user is using that username already.",
        'username.regex' => "username may only contain alpha numeric letters and lowdashes(_), no spaces allowed"
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
        // delete posts when deleting
        static::deleting(function(Profile $profile){
            if($profile->forceDeleting())
            {
                assertInTransaction();
                $profile->posts()->cursor()->each(function(Post $post){
                    $post->forceDelete();
                });
                $profile->profilePosts()->cursor()->each(function(Post $post){
                    $post->forceDelete();
                });
            }
        });
        // set other profiles active state to false when a new profile is created.
        static::created(function(Profile $profile){
            $user = $profile->account;
            if($user->profiles()->count() > 1)
            {
                $user->profiles()->where('id', '!=', $profile->getKey())->whereActive(true)->update(["active" => false]);
            }
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
                $other = $user->profiles()->where('id', '!=', $profile->getKey())->whereActive(true)->first();
                $other->update(["active" => false]);
                // TODO: make sure all model updates are put in a transaction so if an error occurs
                // after this pointthe state of the model will be restored
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
        return $this->hasMany(Post::class, 'author_id')
                     ->whereHasMorph('pageable', Community::class);
    }
    public function profilePosts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }
    public function seenPosts():HasMany
    {
        return $this->hasMany(PostView::class, 'viewer_id');
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class, 'commentor_id');
    }

    public function replies():HasMany
    {
        return $this->hasMany(Comment::class, 'commentor_id')
                    ->whereHasMorph('commentable', Comment::class);
    }

    public function account():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifications():MorphTo
    {
        return $this->morphTo();
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'liker_id');
    }

    public function likedPosts()
    {
        return $this->hasMany(Like::class, 'liker_id')
                    ->whereHasMorph('likeable', Post::class);
    }

    public function likedComments()
    {
        return $this->hasMany(Like::class, 'liker_id')
                    ->whereHasMorph('likeable', Comment::class);
    }

    public function profileImage():MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('purpose', 'profileImage');
    }
    public function coverImage():MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('purpose', 'coverImage');
    }
    public function ownedCommunities():HasMany
    {
        return $this->hasMany(Community::class, 'owner_id');
    }

    public function communities():BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'communities_members', 'profile_id');
    }
    /**
     * @return Collection<CommunityMember>
     */
    public function getSubscriptionsAttribute()
    {
        return CommunityMember::where('profile_id', $this->getKey())->get();
    }
    public function getMemberOf(Community $community):CommunityMember|null
    {
        return CommunityMember::where('community_id', $community->getKey())->where('profile_id', $this->getKey())->first();
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
            Log::error($e->getMessage());
            return null;
        }
    }
    /**
     * returns the id of the currently logged-in user's active profile
     *
     * @return int|null
     */
    public static function current_id():int|null
    {
        try{
            return Auth::user()->activeProfile->getKey();
        }catch(\Throwable $e)
        {
            Log::error($e->getMessage());
            return null;
        }
    }


    public function getUrlAttribute(): string
    {
        return route('profile.show', $this->getAttribute('username'));
    }


    // public static function generateUniqueUserNamesLike($exsisting_username)
    // {
    //     // TODO: make this function give better results
    //     $suggestions = [];
    //     while(count($suggestions) < 3)
    //     {
    //         $r = random_int(0, 100) / 100.0;
    //         if($r > .9)
    //         {
    //             $new = $exsisting_username . '_' . preg_replace('/[^A-Za-z0-9]/', '', Str::random(10));
    //         }else if($r > .8)
    //         {
    //             $new = $exsisting_username . '_' . preg_replace('/[^A-Za-z0-9]/', '', Str::random(10));
    //         }
    //     }
    // }
}
