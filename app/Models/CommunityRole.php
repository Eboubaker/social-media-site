<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommunityRole extends Model
{
    use HasFactory, ModelTraits;
    
    protected $table = 'community_roles';
    public const UPDATED_AT = null;
    public const CREATED_AT = null;
    protected $guraded = [];
    
    public const DEFAULT_ROLE_ID = 1;

    
    public function permissions():BelongsToMany
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
            Log::error($e->getMessage());
            return false;
        }
    }
}
