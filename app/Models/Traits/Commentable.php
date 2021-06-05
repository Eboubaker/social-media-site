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
            assertInTransaction();
            if($commentable->forceDeleting())
            {
                $commentable->comments()->cursor()->each(function(Comment $post){
                    $post->forceDelete();
                });
            }else{
                $commentable->comments()->cursor()->each(function(Comment $post){
                    $post->delete();
                });
            }
        });
    }

    public function comments():MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
