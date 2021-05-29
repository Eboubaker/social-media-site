<?php

namespace App\Models;

use App\Models\Traits\HasStorageUrl;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory, ModelTraits, HasStorageUrl;
    public static $storage = 'videos';
    protected $guarded = [];

    public function videoable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function(Video $video)
        {
            $video->reCalculateSha256Attribute();
        });
        static::created(function(Video $video)
        {
            $video->copyTemporaryFileToStorage();
        });
        static::deleted(function(Video $video){
            unlink($video->realPath);
        });
    }
}
