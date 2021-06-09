<?php

namespace App\Models\Traits;

use App\DataBase\Eloquent\HasMany;
use App\Models\Community;
use App\Models\CommunityRole;
use Illuminate\Database\Eloquent\Model;

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
        return (new HasMany(Community::query(), $this, 'owner_id', 'id'))
                ->afterSave(function(HasMany $relation){
                    $community = $relation->getSavedModel();
                    $community->members()->create([
                        'profile_id' => $this->getKey(),
                        'role_id' => CommunityRole::OWNER_ROLE_ID
                    ]);
                });
    }

    
}