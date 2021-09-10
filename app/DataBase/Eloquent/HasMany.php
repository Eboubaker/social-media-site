<?php

namespace App\DataBase\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany as EloquentHasMany;

class HasMany extends EloquentHasMany
{
    use HasFixedConstraints;
    use HasAfterSaveEvents;

    /**
     * Attach a model instance to the parent model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Model|false
     */
    public function save(Model $model)
    {
        $this->setFixedConstraints($model);
        $result = parent::save($model);
        $this->savedModel = $result;
        $this->callAfterSaveEvents();
        return $result;
    }
}