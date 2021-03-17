<?php


namespace App\Models\Morphs;


use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Commentable
{
    public function comments(): MorphToMany
    {
        return $this->morphToMany(Comment::class, 'postable', 'postables_comments');
    }
}
