<?php


namespace App\Models\Morphs;


use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Commentable
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'postable');
    }
}
