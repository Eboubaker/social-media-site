<?php

namespace App\Models;

class PostableLike extends BaseModel
{
    protected $table = 'postables_likes';
    const CREATED_AT = 'liked_at';
    const UPDATED_AT = null;

    public function profileable()
    {
        return $this->morphTo();
    }
    public function postable()
    {
        return $this->morphTo();
    }
}
