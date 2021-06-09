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
 * App\Models\Community
 *
 * @property string $name
 * @property string $description
 * @property CommunityRole $visitorRole
 * @property CommunityMember $currentMember
 * @property CommunityRole $memberDefaultRole
 * @property int $id
 * @property int $owner_id
 * @property int|null $is_private
 * @property int|null $visitor_role_id
 * @property int|null $member_default_role_id
 * @property-read int|null $members_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read mixed $created
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommunityMember[] $members
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $membersPosts
 * @property-read int|null $members_posts_count
 * @property-read \App\Models\Profile $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $visitorsPosts
 * @property-read int|null $visitors_posts_count
 * @method static \Database\Factories\CommunityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Community newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Community newQuery()
 * @method static \Illuminate\Database\Query\Builder|Community onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Community query()
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereMemberDefaultRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereMembersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereReasonDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereVisitorRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|Community withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Community withoutTrashed()
 * @mixin \Eloquent
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
