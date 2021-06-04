<?php

namespace App\Models;

use App\Models\Traits\HasImages;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;
use Watson\Validating\ValidatingTrait;

/**
 * @property string $name
 * @property string $description
 * 
 */
class Community extends Model
{
    use HasFactory, 
    ModelTraits, 
    Urlable,
    ValidatingTrait,
    HasImages;

    protected $guarded = [];
    protected $rules = [
        'owner_id' => ['exists:App\Models\Profile,id'],
        'name' => ['required', 'unique:App\Models\Community,name', 'min:2', 'max:255', 'regex:/^[A-Za-z0-9\-]+$/'],
        'description' => ['max:255']
    ];
    protected $validationMessages = [
        'username.unique' => "Another user is using that username already.",
        'name.regex' => "name may only contain alpha numeric letters and dashes(-), no spaces allowed."
    ];
    protected $throwValidationExceptions = true;


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
        return $this->morphOne(Image::class, 'imageable')->where('purpose', 'coverImage');
    }
    public function iconImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('purpose', 'iconImage');
    }
}
