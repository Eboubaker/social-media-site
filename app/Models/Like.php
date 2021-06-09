<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use App\Rules\PolymorphicRelationExists;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * App\Models\Like
 *
 * @property int $id
 * @property string $likeable_type
 * @property int $likeable_id
 * @property int $liker_id
 * @property \Illuminate\Support\Carbon|null $liked_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read mixed $created
 * @property-read Model|\Eloquent $likeable
 * @property-read \App\Models\Profile $liker
 * @method static \Illuminate\Database\Eloquent\Builder|Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Like newQuery()
 * @method static \Illuminate\Database\Query\Builder|Like onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Like query()
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereLikeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereLikeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereLikedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereLikerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereReasonDeleted($value)
 * @method static \Illuminate\Database\Query\Builder|Like withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Like withoutTrashed()
 * @mixin \Eloquent
 */
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

    public function __construct(array $args=[])
    {
        parent::__construct($args);
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
