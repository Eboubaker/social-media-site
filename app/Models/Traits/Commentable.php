<?php


namespace App\Models\Traits;

use App\DataBase\Eloquent\MorphMany as CustomMorphMany;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Commentable
{

    public static function bootCommentable()
    {
        static::deleting(function(Model $commentable){
            $commentable->cascadeDeleteRelation(Comment::make(), 'linkedComments');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $commentable){
                $commentable->restoreCascadedRelation('linkedComments');
            });
        }
    }

    public function comments():CustomMorphMany
    {
        $instance = new Comment;
        return new CustomMorphMany($instance->query(), $this, 'commentable_type', 'commentable_id', 'id');
    }

    public function linkedComments():HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
