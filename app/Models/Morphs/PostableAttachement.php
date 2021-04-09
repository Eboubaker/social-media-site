<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\BaseModel;
use App\Models\Events\ModelEvents;
use App\Models\ProfileImage;
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
 * @property object meta
 *
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
    protected $fillable = ['meta', 'storage_id'];
    public static function boot()
    {
        parent::boot();
        static::created(function($model)
        {
            ModelEvents::copyTempToStorage($model);
        });
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
    public function setTemp($path): self
    {
        $this->_tempFile = $path;
        return $this;
    }
    public function getTemp()
    {
        return $this->_tempFile;
    }

    public function createFake()
    {
        $img = new self();
        $disk = Storage::disk('faker_images');
        $files = $disk->files();
        $chosen = $files[random_int(0, count($files)-1)];
        $temp = stream_get_meta_data(tmpfile())['uri'];
        copy($chosen, $temp);
        $img->setTemp($temp);
        $img->setAttribute('content', new \stdClass);
        return $img;
    }

    public function setType($typename)
    {
        $this->setAttribute('type', self::getAllowedTypes()->where('fileSuffix', $typename)->keys()->first());
        return $this;
    }
}
