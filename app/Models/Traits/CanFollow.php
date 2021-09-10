<?php


namespace App\Models\Traits;

use App\Models\Follow;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait CanFollow
{
    public static function bootCanFollow()
    {
        static::deleting(function(Model $follower){
            $follower->cascadeDeleteRelation(Follow::make(), 'followingsModels');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $follower){
                $follower->restoreCascadedRelation('followingsModels');
            });
        }
    }

    public function followingsModels():HasMany
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function followings():BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profiles_followers', 'follower_id', 'profile_id', 'id', 'id');
    }
}
