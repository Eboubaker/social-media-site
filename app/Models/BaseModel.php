<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class BaseModel
 * @package App\Models
 *
 * @method static integer count()
 * @method static bool exists()
 *
 * @method static Builder inRandomOrder()
 * @method static Builder where()
 * @method static Builder orderByDesc()
 * @method static Builder orderBy()
 * @method static Builder with($relation)
 * @method static Builder whereHas()
 * @method static Builder whereDoesntHave()
 *
 * @method static Model make()
 * @method static Model create()
 * @method static Model first()
 *
 * @method static Collection all()
 * @method static Collection get($columns='*')
 *
 *
 *
 */

class BaseModel extends Model
{
    // i added this class just to attach the magic properties
    // and methods of the Model class


    protected $dateFormat = 'm-d-Y HH:MI:SS';


    public function getIdAttribute()
    {
        return $this->getKey();
    }
}
