<?php
namespace App\Models\Traits;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

trait HasFollowers
{
    public static function bootHasFollowers()
    {
        static::deleting(function(Model $profile){
            assertInTransaction();
            if($profile->forceDeleting())
            {
                $this->followers()->delete();
            }
        });
    }
    public function followers():BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profiles_followers', 'profile_id', 'follower_id');
    }
}
