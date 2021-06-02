<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommunityMember extends Model
{
    use ModelTraits, AsPivot;

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
            Log::error("Empty permission id");
            return false;
        }
        try {
            return DB::table('community_roles_permissions')
                        ->where('role_id', $this->role_id)
                        ->where('permission_id', $permissionId)
                        ->exists();
        }catch(\Throwable $e)
        {
            Log::error($e->getMessage());
            return false;
        }
    }
    public function getPermissionsAttribute()
    {
        return $this->role->permissions;
    }
    #region RELATIONS

    public function role()
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
