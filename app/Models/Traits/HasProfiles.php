<?php


namespace App\Models\Traits;


use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasProfiles
{
    public static function bootHasProfiles()
    {
        static::deleting(function($owner){
            assertInTransaction();
            if($owner->forceDeleting())
            {
                info("force deleting user #".$owner->getKey() . " profiles");
                $owner->profiles()->cursor()->each(fn($profile) => $profile->forceDelete());
            }else{
                info("deleting user #".$owner->getKey() . " profiles");
                $owner->profiles()->cursor()->each(fn($profile) => $profile->delete());
            }
        });
    }
    public function profiles():HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
