<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasPosts;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Community extends Model
{
    use HasFactory, ModelTraits, HasAuthor;

    public function members()
    {
        return $this->hasMany(CommunityMember::class, 'community_id');
    }
    public function posts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }
    public function owner()
    {
        return $this->author();
    }
}
