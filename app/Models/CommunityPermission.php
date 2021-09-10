<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CommunityPermission
 *
 * @property int $id
 * @property string $name
 * @property-read mixed $created
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommunityMember[] $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CommunityRole[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityPermission whereName($value)
 * @mixin \Eloquent
 */
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
