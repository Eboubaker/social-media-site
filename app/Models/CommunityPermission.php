<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPermission extends Model
{
    use HasFactory, ModelTraits;
    
    public const UPDATED_AT = null;
    public const CREATED_AT = null;
    
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(CommunityRole::class, 'community_roles_permissions');
    }

    public function members()
    {
        return $this->hasManyThrough(CommunityMember::class, CommunityRole::class, firstKey:'permission_id', secondKey:'role_id');
    }
}
