<?php
namespace App\Models\Traits;

use App\Models\CommunityMember;
use App\Models\Follow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasMembers
{
    public static function bootHasMembers()
    {
        static::deleting(function(Model $space){
            $space->cascadeDeleteRelation(CommunityMember::make(), 'members');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $space){
                $space->restoreCascadedRelation('members');
            });
        }
    }
    public function members(): HasMany
    {
        return $this->hasMany(CommunityMember::class);
    }
}
