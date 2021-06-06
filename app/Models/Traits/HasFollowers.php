<?php
namespace App\Models\Traits;

use App\Models\Follow;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

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

    public function followersModels()
    {
        return $this->hasMany(Follow::class, 'profile_id');
    }

    public function followers():BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profiles_followers', 'profile_id', 'follower_id');
    }
}
