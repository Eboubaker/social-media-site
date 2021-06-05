<?php

namespace App\Models\Traits;

use App\Models\Community;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CreatesCommunities
{
    public function ownedCommunities():HasMany
    {
        return $this->HasMany(Community::class, 'owner_id');
    }

    public static function bootCreatesCommunities()
    {
        static::deleting(function($author){
            assertInTransaction();
            if($author->forceDeleting())
            {
                $author->ownedCommunities()->cursor()->each(function(Community $community){
                    $community->forceDelete();
                });
            }
        });
    }
}