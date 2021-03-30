<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


/**
 * Class BaseModel
 * @package App\Models
 *
 * @method static integer count()
 * @method bool exists()
 *
 * @method static Builder inRandomOrder()
 * @method static Builder where()
 * @method static Builder orderByDesc()
 * @method static Builder orderBy()
 * @method static Builder with($relation)
 * @method static Builder whereHas()
 * @method static Builder whereDoesntHave()
 * @method static self make()
 * @method static self create()
 * @method static self first()
 *
 * @method static Collection all()
 * @method static Collection get($columns='*')
 *
 * @method integer|string getKey()

 *
 *
 */

class BaseModel extends Model
{
    public const PUBLIC_ID_LEN = 8;
    // i added this class just to attach the magic properties
    // and methods of the Model class



//    public function getIdAttribute()
//    {
//        return $this->attributes[self::PKEY];
//    }

    public function makeUuid($uuid = null)
    {
        $this->setAttribute($this->getKeyName(), $uuid ?? Str::uuid()->toString());
    }
    public function makePublicId()
    {
        $this->setAttribute('public_id', Str::random(self::PUBLIC_ID_LEN));
    }

    public function joinMe(Builder $query, Model $model)
    {
        $query->join($this->getTable(), $this->getKey(), $model->getForeignKey());
    }
}
