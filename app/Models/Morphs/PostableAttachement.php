<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\BaseModel;
use App\Models\Events\ModelEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
    public static $allowedTypes = [];
    public $storage;
    public $_tempFile;
    private $fformat;
    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            ModelEvents::addSha256($model);
        });
        static::created(function($model)
        {
            ModelEvents::copyTempToStorage($model);
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
        if(empty($this->fformat))
        {
            $this->fformat = self::getAllowedTypes()->where('typeId', $this->getAttribute('type'))->get('format');
        }
        return $this->fformat;
    }
    public function getFileNameAttribute(): string
    {
        return $this->getAttribute('storage_id') .".". $this->fileFormat;
    }
    public function getRealPathAttribute(): string
    {
        return Storage::disk($this->storage)->path($this->fileName);
    }

    public static function getAllowedTypes(): Collection
    {
        return collect(self::$allowedTypes);
    }
}
