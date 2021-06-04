<?php


namespace App\Models\Traits;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

trait CanFollow
{
    public function followings():BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profiles_followers', 'follower_id');
    }
    public static function bootCanFollow()
    {
        static::deleting(function(Model $profile){
            assertInTransaction();
            info("CanFollow.boot.deleting");
            if($profile->forceDeleting())
            {
                DB::table('profiles_followers')->where('follower_id', $profile->getKey())->delete();
            }
        });
    }
}
