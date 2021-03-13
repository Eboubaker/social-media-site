<?php

namespace App\Models\Morphs;

use App\Models\BaseModel;
use App\Models\Funcs\ModelFuncs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\AssignOp\Mod;

/**
 * @property string fileFormat
 * @property string fileName
 * @property string url
 * @property string realPath
 */
class PostableAttachement extends BaseModel
{
    use HasFactory;
    public $keyType = 'string';
    public $incrementing = false;

    public const PKEY = "uuid";
    protected $guarded = [];
    protected $hidden = [];
    public $allowedTypes = [];
    public $storage;

    function __construct(array $attributes = [], $pass = false)
    {
        parent::__construct($attributes);
        if(!$pass) {
            $handler = app()->get(ModelFuncs::class);
            $HasUuid = $handler->funcs[ModelFuncs::$HasUuid];
            $HasSha256 = $handler->funcs[ModelFuncs::$HasSha256];
            $UnlinkOnDelete = $handler->funcs[ModelFuncs::$UnlinkOnDelete];
            static::creating($HasUuid);
            static::deleted($UnlinkOnDelete);
            static::creating($HasSha256);
            static::updating($HasSha256);
        }
    }

    public function postable()
    {
        return $this->morphTo(Postable::$morphRelationName, null, null, Postable::PKEY);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->storage)->url($this->fileName);
    }

    public function getFileFormatAttribute()
    {
        return $this->allowedTypes[$this->attributes['type']]['fileSuffix'] ?? null;
    }
    public function getFileNameAttribute(): string
    {
        return $this->attributes[self::PKEY] .".". $this->fileFormat;
    }

    public function getRealPathAttribute(): string
    {
        return Storage::disk($this->storage)->path($this->fileName);
    }

}
