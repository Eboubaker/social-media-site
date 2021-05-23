<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;



trait ModelTraits
{
    protected static $instance;

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
}
