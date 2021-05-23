<?php

namespace App\Models;

use App\Models\Traits\HasStorageUrl;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, ModelTraits, HasStorageUrl;

    public $storage = 'images';
    protected $guarded = [];
    

    public function imageable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function(Image $image)
        {
            $image->reCalculateSha256Attribute();
        });
        static::created(function(Image $image)
        {
            $image->copyTemporaryFileToStorage();
        });
    }
}
