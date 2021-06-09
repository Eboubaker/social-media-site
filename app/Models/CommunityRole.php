<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\CommunityRole
 *
 * @property int $id
 * @property string $name
 * @property-read mixed $created
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommunityMember[] $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommunityPermission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityRole whereName($value)
 * @mixin \Eloquent
 */
class CommunityRole extends Model
{
    use HasFactory, ModelTraits;
    
    public const UPDATED_AT = null;
    public const CREATED_AT = null;
    
    protected $guarded = [];
    
    public const MEMBER_DEFAULT_ROLE_ID = 1;
    public const OWNER_ROLE_ID = 2;
    public const VISITOR_DEFAULT_ROLE_ID = 3;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(CommunityPermission::class, 'community_roles_permissions', foreignPivotKey:'role_id', relatedPivotKey:'permission_id');
    }
    public function members()
    {
        return $this->hasMany(CommunityMember::class, 'role_id');
    }
    public function can(int $permissionId): bool
    {
        try {
            return DB::table('community_roles_permissions')
                        ->where('role_id', $this->getKey())
                        ->where('permission_id', $permissionId)
                        ->exists();
        }catch(\Throwable $e)
        {
            report($e);
            return false;
        }
    }
}
