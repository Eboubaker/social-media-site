<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends BaseModel
{
    use HasFactory;
    public const TABLE = "user_notifications";
    public const PKEY = "id";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::PKEY;
    public const FKEY = "user_notification_id";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = null;

    protected $table = self::TABLE;
    protected $primaryKey = self::PKEY;

    protected $guarded = [
        self::PKEY
    ];
    protected $hidden = [
        self::PKEY
    ];
    protected $casts = [
        'content' => 'object'
    ];


}
