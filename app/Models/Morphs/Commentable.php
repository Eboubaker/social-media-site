<?php


namespace App\Models\Morphs;



use App\Models\BaseModel;
use App\Models\BusinessProfile;
use App\Models\Funcs\ModelFuncs;
use App\Models\SocialProfile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commentable
 * @package App\Models\Morphs
 * @property BusinessProfile|SocialProfile profileable
 */
class Commentable extends BaseModel
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    public const PKEY = 'uuid';

    public const TABLE = 'commentables';
    /**
     * @var mixed
     */
    public static $morphRelationName = 'commentable';
    protected $guarded = [];
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'upadted_at';
    public static $onCreating = [];

    protected $primaryKey = self::PKEY;

    function __construct(array $attributes = [], $pass = false)
    {
        parent::__construct($attributes);

        $hids = $this->getHidden();
        $hids[] = 'pivot';
        $this->setHidden($hids);
    }
    public function profileable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo(Profileable::$morphRelationName, null, null, Profileable::PKEY);
    }

    public function commentable()
    {
        return $this->morphTo(self::$morphRelationName, null, null, null);
    }
}
