<?php
namespace App\Models\Traits;

use App\Models\Follow;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @property Collection<Profile> $followers
 */
trait HasFollowers
{
    public static function bootHasFollowers()
    {
        static::deleting(function(Model $followable){
            $followable->cascadeDeleteRelation(Follow::make(), 'followersModels');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $followable){
                $followable->restoreCascadedRelation('followersModels');
            });
        }
    }

    public function followersModels():HasMany
    {
        return $this->hasMany(Follow::class, 'profile_id');
    }

    public function followers():BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profiles_followers', 'profile_id', 'follower_id');
    }
}
