<?php

namespace App\Models;

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
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @property string lastName
 * @property User $account
 */
class Profile extends Model
{
    use HasFactory, Notifiable, HasDatabaseNotifications, ModelTraits, SoftDeletes, Urlable;
    
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];


    public static function boot()
    {
        parent::boot();
        static::creating(function(Profile $profile){
            $profile->setAttribute('active', true);
        });
        static::created(function(Profile $profile){
            $user = $profile->account;
            $user->refresh();
            if($user->profiles()->count() > 1)
            {
                $user->profiles()->where('id', '!=', $profile->getKey())->whereActive(true)->update(["active" => false]);
            }
        });
        static::updating(function(Profile $profile){
            $user = $profile->account;
            if((bool)$profile->active !== (bool)$profile->getOriginal('active') && (bool)$profile->active === true)
            {
                if ($user->profiles()->count() <= 1) 
                {
                    throw new \Exception("attempting to deactivate profile while the user only has one profile");
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
        return $this->morphOne(Image::class, 'imageable')->ofMany(relation:function($query){
            $query->where('purpose', 'profileImage');
        });
    }
    public function coverImage():MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany(relation:function($query){
            $query->where('purpose', 'coverImage');
        });
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

    public function followers()
    {
        return $this->belongsToMany(Profile::class, 'profiles_followers', 'follower_id');
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
}
