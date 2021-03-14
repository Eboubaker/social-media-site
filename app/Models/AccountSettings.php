<?php

namespace App\Models;

use App\Casts\JsonObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSettings extends BaseModel
{
    use HasFactory;
    public const TABLE = "account_settings";
    public const PKEY = "id";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "account_settings_id";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";

    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;

    protected $guarded = [
        self::PKEY
    ];
    protected $hidden = [
        self::PKEY
    ];
    protected $casts = [
        'data' => JsonObject::class
    ];
}
