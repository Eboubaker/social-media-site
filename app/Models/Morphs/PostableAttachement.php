<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\BaseModel;
use App\Models\Events\ModelEvents;
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

    public const PKEY = 'id';
    protected $primaryKey = self::PKEY;

    protected $guarded = [];
    protected $hidden = [];
    public $allowedTypes = [];
    public $storage;

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            ModelEvents::addSha256($model);
        });
        static::deleted(function($model)
        {
            ModelEvents::removeAssociatedFiles($model);
        });
    }
    function __construct(array $attributes = [], $pass = false)
    {
        $this->casts['meta'] = JsonObject::class;
        parent::__construct($attributes);
    }

    public function postable()
    {
        return $this->morphTo('postable');
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
        return $this->getKey() .".". $this->fileFormat;
    }

    public function getRealPathAttribute(): string
    {
        return Storage::disk($this->storage)->path($this->fileName);
    }

}
