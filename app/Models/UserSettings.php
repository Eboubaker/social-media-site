<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    use HasFactory, ModelTraits;

    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    public const DELETED_AT = null;

    
    protected $table = 'users_settings';

    protected $guarded = [];

}
