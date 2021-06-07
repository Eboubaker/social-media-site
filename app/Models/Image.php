<?php

namespace App\Models;

use App\Models\Traits\HasStorageUrl;
use App\Models\Traits\ModelTraits;
use App\Rules\PolymorphicRelationExists;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Image extends Model
{
    use HasFactory, 
    ModelTraits, 
    HasStorageUrl,
    SoftDeletes;

    public $storage = 'images';
    protected $guarded = [];
    
    protected $rules = [

    ];
    protected $validationMessages = [

    ];
    protected $validationAttributeNames = [
        'imageable_id' => 'The related item'
    ];
    protected $throwValidationExceptions = true;


    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->rules['imageable_id'][] = new PolymorphicRelationExists($this, 'imageable');
    }
    public function imageable()
    {
        return $this->morphTo();
    }
}
