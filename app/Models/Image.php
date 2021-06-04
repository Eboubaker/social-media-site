<?php

namespace App\Models;

use App\Models\Traits\HasStorageUrl;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, 
    ModelTraits, 
    HasStorageUrl,
    SoftDeletes;

    public $storage = 'images';
    protected $guarded = [];
    

    public function imageable()
    {
        return $this->morphTo();
    }
}
