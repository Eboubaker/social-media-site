<?php


namespace App\Models\Traits;

use App\Models\Comment;
use App\Models\Community;
use App\Models\CommunityMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

trait CanJoinCommunities
{

    public static function bootCanJoinCommunities()
    {
        static::deleting(function(Model $profileable){
            $profileable->cascadeDeleteRelation(CommunityMember::make(), 'communitiesSubscriptions');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $profileable){
                $profileable->restoreCascadedRelation('communitiesSubscriptions');
            });
        }
    }
    public function communitiesSubscriptions():HasMany
    {
        return $this->hasMany(CommunityMember::class, 'profile_id');
    }
    
    public function subscriptionForCommunity($community):CommunityMember|null
    {
        if($community instanceof Community)
        {
            $community_id = $community;
        }else{
            $community_id = $community->getKey();
        }
        return $this->communitiesSubscriptions()->where('community_id', $community_id)->first();
    }

    public function isSubscripedTo($community):bool
    {
        if($community instanceof Community)
        {
            $community_id = $community;
        }else{
            $community_id = $community->getKey();
        }
        return DB::table(CommunityMember::tablename())
                    ->where('community_id', $community_id)
                    ->where('profile_id', $this->getKey())
                    ->exists();
    }

    
}
