<?php


namespace App\Models\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

trait CanComment
{
    public static function bootCanComment()
    {
        static::deleting(function(Model $commentor){
            $commentor->cascadeDeleteRelation(Comment::make(), 'comments');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $commentor){
                $commentor->restoreCascadedRelation('comments');
            });
        }
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class, 'commentor_id');
    }
   
}
