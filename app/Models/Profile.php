<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\HasDatabaseNotifications;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property string lastName
 */
class Profile extends Model
{
    use HasFactory, Notifiable, HasDatabaseNotifications, ModelTraits, SoftDeletes;
    
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
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
        return $this->morphOne(Image::class, 'imageable');
    }

    public function createdCommunities():HasMany
    {
        return $this->hasMany(Community::class, 'owner_id');
    }

    public function communities():BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'communities_members', 'profile_id');
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
}
