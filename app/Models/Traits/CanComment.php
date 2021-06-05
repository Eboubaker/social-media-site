<?php


namespace App\Models\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanComment
{
    public static function bootCanComment()
    {
        static::deleting(function(Model $commentor){
            assertInTransaction();
            if($commentor->forceDeleting())
            {
                $commentor->ownedCommunities()->cursor()->each(function(Comment $comment){
                    $comment->forceDelete();
                });
            }
        });
    }
    
    public function comments():HasMany
    {
        return $this->hasMany(Comment::class, 'commentor_id');
    }
   
}
