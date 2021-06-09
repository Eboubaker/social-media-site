<?php

namespace App\Models;

use App\DataBase\Eloquent\MorphOne;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasMembers;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Watson\Validating\ValidatingTrait;

/**
 * @property string $name
 * @property string $description
 * @property CommunityRole $visitorRole
 * @property CommunityMember $currentMember
 * @property CommunityRole $memberDefaultRole
 */
class Community extends Model
{
    use HasFactory, 
    SoftDeletes,
    ValidatingTrait,
    Urlable,

    ModelTraits,
    HasImages,
    HasMembers;


    protected $guarded = [];
    protected $rules = [
        'owner_id' => ['exists:App\Models\Profile,id'],
        'name' => ['required', 'unique:App\Models\Community,name', 'min:2', 'max:20', 'regex:/^[A-Za-z]+$/'],
        'description' => ['max:255']
    ];
    protected $validationMessages = [
        'username.unique' => "Another user is using that username already.",
        'name.regex' => "name must only contain letters (a-z or A-Z) no spaces allowed"
    ];
    protected $throwValidationExceptions = true;



    public function posts():MorphMany
    {
        return $this->morphMany(Post::class, 'pageable');
    }
    public function membersPosts():MorphMany
    {
        // don't put get after select
        return $this->posts()->whereIn('author_id', $this->members()->select('profile_id'));
    }
    public function visitorsPosts():MorphMany
    {
        // don't put get after select
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
    public function currentMember():HasOne
    {
        $builder = $this->members()->where('profile_id', Profile::current_id());

        $relation = new HasOne($builder->getQuery(), $this, $this->getForeignKey(), $this->getKeyName());

        return $relation; // or return $relation->withDefault()
    }
    public function currentIsMember():bool
    {
        return $this->currentMember()->exists();
    }
    public function getUrlAttribute(): string
    {
        return route('community.show', $this->name);
    }

    public function coverImage():MorphOne
    {
        return (new MorphOne(Image::query()
                            , $this
                            , 'images.imageable_type'
                            , 'images.imageable_id', 'id'
                ))->withFixedConstraint('purpose', __FUNCTION__);
    }
    public function iconImage():MorphOne
    {
        return (new MorphOne(Image::query()
                            , $this
                            , 'images.imageable_type'
                            , 'images.imageable_id', 'id'
                ))->withFixedConstraint('purpose', __FUNCTION__);
    }

    public function visitorRole():BelongsTo
    {
        return $this->belongsTo(CommunityRole::class, 'visitor_role_id');
    }

    public function memberDefaultRole():BelongsTo
    {
        return $this->belongsTo(CommunityRole::class, 'member_default_role_id');
    }
    /**
     * 
     * Does this community allow this action for the given user?
     * 
     * @param int|Profile $profile a profile model or a profile_id 
     * @param int $permission_id if of the permission
     * @return true if this community allows the action for the given profile 
     * @return false if this community does not allow the profile to do the action
     */
    public function allows($permission_id, $profile): bool
    {
        if(empty($permission_id) || empty($profile))
            return false;
        $profile_id = $profile instanceof Profile ? $profile->getKey() : $profile;
        if( ! is_null($member = $this->members()->where('profile_id', $profile_id)->first(['id', 'role_id'])))
        {
            
            return $member->can($permission_id);
        }else
        {
            // if the profile is not a member of this communtiy then
            // fallback to the visitor role
            return $this->visitorRole->can($permission_id);
        }
    }
    /**
     * 
     * Does this community allow this action for the current profile?
     * 
     * @param int $permission_id if of the permission
     * @return true if this community allows the action for the current profile 
     * @return false if this community does not allow the current profile to do the action
     */
    public function allowsCurrent(int $permission_id): bool
    {
        return $this->allows($permission_id, Profile::current_id());
    }
}
