<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserSettings
 *
 * @property int $id
 * @property int $user_id
 * @property-read mixed $created
 * @method static \Database\Factories\UserSettingsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereUserId($value)
 * @mixin \Eloquent
 */
class UserSettings extends Model
{
    use HasFactory, ModelTraits;

    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    public const DELETED_AT = null;

    
    protected $table = 'users_settings';

    protected $guarded = [];

}
