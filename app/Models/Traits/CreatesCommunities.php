<?php

namespace App\Models\Traits;

use App\Models\Community;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CreatesCommunities
{
    public static function bootCreatesCommunities()
    {
        static::deleting(function(Model $owner){
            $owner->cascadeDeleteRelation(Community::make(), 'ownedCommunities');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $owner){
                $owner->restoreCascadedRelation('ownedCommunities');
            });
        }
    }

    public function ownedCommunities():HasMany
    {
        return $this->HasMany(Community::class, 'owner_id');
    }

    
}