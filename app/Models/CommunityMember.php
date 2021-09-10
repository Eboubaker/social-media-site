<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\CommunityMember
 *
 * @property int $id
 * @property int $profile_id
 * @property int $community_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $joined_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Community $community
 * @property-read mixed $created
 * @property-read mixed $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\CommunityRole $role
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommunityMember extends Model
{
    use ModelTraits, 
    AsPivot;

    protected $table = 'communities_members';
    public const CREATED_AT = 'joined_at';
    public const UPDATED_AT = 'updated_at';

    
    protected $guarded = [];

    /**
     * @return CommunityMember|null
     */
    public function current(int|Community $community):CommunityMember|null
    {
        if($community  instanceof Community)
        {
            $community_id = $community->getKey();
        }else{
            $community_id = $community;
        }
        return CommunityMember::where('profile_id', Profile::current_id())->where('community_id', $community_id)->first();
    }
    public function can($permissionId): bool
    {
        if (empty($permissionId)) 
        {
            return false;
        }
        try {
            return DB::table('community_roles_permissions')
                        ->where('role_id', $this->role_id)
                        ->where('permission_id', $permissionId)
                        ->exists();
        }catch(\Throwable $e)
        {
            report($e);
            return false;
        }
    }
    public function getPermissionsAttribute()
    {
        return $this->role->permissions;
    }
    #region RELATIONS

    public function role():BelongsTo
    {
        return $this->belongsTo(CommunityRole::class, 'role_id');
    }
    public function posts():HasMany
    {
        return $this->hasMany(Post::class, 'author_id', 'profile_id')
        ->whereHasMorph('pageable', Community::class)
        ->where('pageable_id', $this->getAttribute(Community::getForegin()));
    }
    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
    #endregion

    // public function create(array $attributes)
    // {
    //     // the only way to create a member is only with one of these
    //     // $profile->communities()->save($community);
    //     // $community->members()->save($profile);
    //     throw new Exception("METHOD CREATE NOT IMPLEMENTED");
    // }
}
