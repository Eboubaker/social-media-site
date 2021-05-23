<?php

namespace App\Models;

use App\Models\Traits\HasCompositePrimaryKey;
use App\Models\Traits\ModelTraits;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommunityMember extends Model
{
    use SoftDeletes, ModelTraits, AsPivot;

    protected $table = 'communities_members';
    public const CREATED_AT = 'joined_at';
    public const UPDATED_AT = 'updated_at';

    

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
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'member_id')
        ->whereHasMorph('pageable', Community::class)
        ->where('pageable_id', $this->getAttribute(Community::getForegin()));
    }

    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'member_id');
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
