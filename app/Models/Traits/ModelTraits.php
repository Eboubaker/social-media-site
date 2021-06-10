<?php

namespace App\Models\Traits;

use App\CustomScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


/**
 * @method static void doForceDelete()
 * @method static Builder where($attribute, $value)
 * @method static void includeTrashed()
 * @method static void onlyIncludeTrashed()
 * @method static void cascadeTrash()
 * @method static void restoreCascadedTrashes()
 * @method static void restoreCascadedTrashes()
 * @method static $this create(array $attributes)
 * @method static $this make(array $attributes)
 * @method static Collection<$this> all()
 * 
 * @mixin Illuminate\Database\Eloquent\Builder;
 */
trait ModelTraits
{
    protected static $instance = null;
    public static $usesSoftDeletes = null;
    protected static $deletedAtColumnName = null;


    public static function instance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public static function bootModelTraits()
    {
        static::addGlobalScope(new CustomScopes);
    }

    public function doForceDelete()
    {
        if($this->canBeSoftDeleted())
        {
            return $this->forceDelete();
        }else{
            return $this->delete();
        }
    }
    public static function canBeSoftDeleted():bool
    {
        if (is_null(self::$usesSoftDeletes)) 
        {
            self::$usesSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive(self::class));
        }
        return self::$usesSoftDeletes;
    }
    public function forceDeleting():bool
    {
        return $this->canBeSoftDeleted() ? $this->isForceDeleting() : true;
    }
    public static function getDeletedAtName():string
    {
        if(is_null(self::$deletedAtColumnName))
        {
            $instance = new self;
            if($instance->canBeSoftDeleted())
            {
                self::$deletedAtColumnName = $instance->getDeletedAtColumn();
            }else{
                self::$deletedAtColumnName = 'deleted_at';
            }
        }
        return self::$deletedAtColumnName;
    }
    public function softDeleting()
    {
        return ! $this->forceDeleting();
    }
    public function getCreatedAttribute()
    {
        return Carbon::parse($this->attributes[$this->getCreatedAtColumn()]);
    }
    public function getTableDotKey()
    {
        return $this->getTable() . "." . $this->getKey();
    }
    public function getTableDotForeignKey(Model $model)
    {
        return $model->getTable() . "." . $this->getKey();
    }
    public static function joinWithSelf(Builder $query) : Builder
    {
        $with = $query->getModel();
        if(empty(self::$instance))
            self::$instance = new self;
        return $query->join(self::$instance->getTable(), 
                self::$instance->getTableDotForeignKey($with),
                '=',
                self::$instance->getTableDotKey());
    }

    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
    {
        if (is_null($relation)) {
            $relation = $this->guessBelongsToRelation();
        }

        $instance = $this->newRelatedInstance($related);
        if (is_null($foreignKey)) {
            $foreignKey = $instance->getForeignKey();
        }
        $ownerKey = $ownerKey ?: $instance->getKeyName();

        return $this->newBelongsTo(
            $instance->newQuery(), $this, $foreignKey, $ownerKey, $relation
        );
    }
    public static function urlname()
    {
        return strtolower(class_basename(self::class));
    }


    public function makeUuid($uuid = null)
    {
        $this->setAttribute($this->getKeyName(), $uuid ?? Str::uuid()->toString());
    }
    public function joinMe(Builder $query, Model $model)
    {
        $query->join($this->getTable(), $this->getKey(), $model->getForeignKey());
    }

    public static function tablename()
    {
        if(empty(self::$instance))
            self::$instance = new self;
        return self::$instance->getTable();
    }
    public static function getId()
    {
        if(empty(self::$instance))
            self::$instance = new self;
        return self::$instance->getKeyName();
    }


    public static function getForegin()
    {
        if(empty(self::$instance))
            self::$instance = new self;
        return self::$instance->getForeignKey();
    }

    public static function random($count = 0):static
    {
        return $count <= 0
                        ? self::orderByRaw('rand()')->first()
                        : self::orderByRaw('rand()')->limit($count)->get();
    }

    public function identifyYourSelf():string
    {
        return (string)(get_class($this)."#".$this->getKey());
    }

    public function getMorphConstraints($relation)
    {
        return [
            $relation."_id" => $this->getKey(),
            $relation."_type" => $this->getMorphClass()
        ];
    }
}
