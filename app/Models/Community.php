<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

/**
 * @property string $name
 * @property string $description
 * 
 */
class Community extends Model
{
    use HasFactory, ModelTraits, Urlable;

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
        // don't put get
        return $this->posts()->whereIn('author_id', $this->members()->select('profile_id'));
    }
    public function nonMembersPosts():MorphMany
    {
        // don't put get
        return $this->posts()->whereNotIn('author_id', $this->members()->select('profile_id'));
    }
    public function owner():BelongsTo
    {
        return $this->belongsTo(Profile::class, 'owner_id');
    }
    public function getMemberOf(Profile $profile):CommunityMember|null
    {
        return CommunityMember::where('profile_id', $profile->getKey())->where('community_id', $this->getKey())->first();
    }
    public function currentMember():CommunityMember|null
    {
        return CommunityMember::where('profile_id', Profile::current_id())->where('community_id', $this->getKey())->first();
    }
    public function getMemberOfId(int $profile_id):CommunityMember|null
    {
        return CommunityMember::where('profile_id', $profile_id)->where('community_id', $this->getKey())->first();
    }
    public function getUrlAttribute(): string
    {
        return route('community.show', $this->name);
    }

    public function coverImage()
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany(relation:function($query){
            $query->where('purpose', 'coverImage');
        });
    }
    public function iconImage()
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany(relation:function($query){
            $query->where('purpose', 'iconImage');
        });
    }
}
