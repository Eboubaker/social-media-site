<?php


namespace App\Models\Traits;


use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{

    public static function bootCommentable()
    {
        static::deleting(function(Model $commentable){
            $commentable->cascadeDeleteRelation(Comment::make(), 'comments');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $commentable){
                $commentable->restoreCascadedRelation('comments');
            });
        }
    }

    public function comments():MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
