<?php


namespace App\Models\Traits;


use App\Models\Comment;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasProfiles
{
    public static function bootHasProfiles()
    {
        static::deleting(function(User $owner){
            info("event HasProfiles.deleting was dispatched, dispatcher: " . get_class($owner) . "#".$owner->getKey());
            $owner->cascadeDeleteRelation(Profile::make(), 'profiles');
        });
        if(self::canBeSoftDeleted())
        {
            info("event HasProfiles.restored was registered");
            static::restored(function(User $owner){
                info("event HasProfiles.restored was dispatched, dispatcher: " . get_class($owner) . "#".$owner->getKey());
                $owner->restoreCascadedRelation('profiles');
            });
        }
    }
    public function profiles():HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
