<?php

namespace App\Models;

use App\Models\Traits\HasStorageUrl;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, 
    ModelTraits, 
    HasStorageUrl,
    SoftDeletes;

    public static $storage = 'videos';
    protected $guarded = [];

    public function videoable()
    {
        return $this->morphTo();
    }

    
}
