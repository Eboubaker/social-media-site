<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IncludeIsLikedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // $builder->whereNull($model->getQualifiedDeletedAtColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        $builder->macro('includeIsLikedAttribute', function (Builder $builder, $profile_id) {
            if(empty($builder->getQuery()->columns))
            {
                $builder->select($builder->getModel()->getTable().'.*');
            }
            return $builder->selectRaw("(select exists(select * from likes where likes.likeable_id=".$builder->getModel()->getTable().".id and likes.likeable_type=? and likes.liker_id=?)) as is_liked", [$builder->getModel()->getMorphClass(), $profile_id]);
        });
    }
}
