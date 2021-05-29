<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class Community extends Model
{
    use HasFactory, ModelTraits;

    protected $guarded = [];
    
    public function members()
    {
        return $this->hasMany(CommunityMember::class);
    }
    public function posts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }
    public function membersPosts():MorphMany
    {
        return $this->posts()->whereIn('author_id', $this->members()->select('profile_id'));
    }
    public function nonMembersPosts():MorphMany
    {
        // TODO:
        return $this->morphMany(Post::class, 'pageable');
    }
    public function owner():BelongsTo
    {
        return $this->belongsTo(Profile::class, 'owner_id');
    }
    public function getMemberOf(Profile $profile):CommunityMember|null
    {
        return CommunityMember::where('profile_id', $profile->getKey())->where('community_id', $this->getKey())->first();
    }
}
