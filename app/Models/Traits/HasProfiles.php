<?php


namespace App\Models\Traits;


use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasProfiles
{
    public static function bootHasProfiles()
    {
        static::deleting(function(User $owner){
            if($owner->softDeleting()){
                $owner->cascadeDeleteRelation(Profile::make(), 'profiles');
            }
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(User $owner){
                $owner->restoreCascadedRelation('profiles');
            });
        }
    }
    public function profiles():HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
