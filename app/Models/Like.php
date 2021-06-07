<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use App\Rules\PolymorphicRelationExists;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Like extends Model
{
    use HasFactory, 
    SoftDeletes,
    ModelTraits,
    ValidatingTrait;

    public const CREATED_AT = 'liked_at';
    public const UPDATED_AT = null;

    protected $guarded = [];
    
    protected $rules = [
        'liker_id' => ['required', 'exists:App\Models\Profile,id']
    ];
    protected $validationMessages = [
        'liker_id.exists' => "the liker does not exist.",
    ];
    protected $validationAttributeNames = [
        'liker_id' => 'liker',
        'likeable' => "related item"
    ];

    protected $throwValidationExceptions = true;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->rules['likeable_id'][] = new PolymorphicRelationExists($this, 'likeable');
    }
    public function likeable()
    {
        return $this->morphTo();
    }

    public function liker()
    {
        return $this->belongsTo(Profile::class, 'liker_id');
    }
}
