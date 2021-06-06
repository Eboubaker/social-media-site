<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;

class CustomScopes implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var string[]
     */
    protected $extensions = [
        'TreeDelete', 
        'TreeRestore',
        'TreeRestoreCascaded',
        'TreeForceDelete',

        'CascadeDeleteRelation',
        'RestoreCascadedRelation',

        'IncludeTrashed',
        'OnlyIncludeTrashed',
    ];
    // cascadeDeleteRelation
    // restoreCascadedRelation
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
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }
    

    protected function addTreeDelete(Builder $builder)
    {
        $builder->macro('treeDelete', function (Builder $builder) {
            return $builder
                ->cursor()
                ->each(function($model){
                    info("calling delete on " . get_class($model));
                    $model->delete();
                });
        });
    }

    protected function addTreeForceDelete(Builder $builder)
    {
        $builder->macro('treeForceDelete', function (Builder $builder) {
            if($builder->getModel()->canBeSoftDeleted())
            {
                return $builder->cursor()->each(function($model){
                    $model->forceDelete();
                });
            }else{
                return $builder->cursor()->each(function($model){
                    $model->delete();
                });
            }
        });
    }

    protected function addCascadeDeleteRelation(Builder $builder)
    {
        $builder->macro('cascadeDeleteRelation', function (Builder $builder, $relatedInstance, string $relation) {
            $parent = $builder->getModel();
            Log::debug("Cascading deleting of relation $relation with ".get_class($builder->getModel()));
            if($parent->forceDeleting())
            {
                return $parent->{$relation}()->includeTrashed()->treeForceDelete();
            }else if($relatedInstance->canBeSoftDeleted())
            {
                return $parent->{$relation}()
                ->cursor()
                ->each(function($model){
                    $model->update(['reason_deleted' => REASON_CASCADE]);
                    $model->delete();
                });
            }
            return $builder;
        });
    }
    protected function addRestoreCascadedRelation(Builder $builder)
    {
        $builder->macro('restoreCascadedRelation', function (Builder $builder, string $relation) {
            return $builder->getModel()->{$relation}()->treeRestoreCascaded();
        });
    }
    protected function addTreeRestoreCascaded(Builder $builder)
    {
        $builder->macro('treeRestoreCascaded', function (Builder $builder) {
            if($builder->getModel()->canBeSoftDeleted())
            {
                return $builder->where('reason_deleted', REASON_CASCADE)->treeRestore();
            }
            return $builder;
        });
    }
    protected function addTreeRestore(Builder $builder)
    {
        $builder->macro('treeRestore', function (Builder $builder) {
            info("Tree restore called for model query " . $builder->getModel()->identifyYourself());
            if($builder->getModel()->canBeSoftDeleted())
            {
                return $builder
                ->onlyIncludeTrashed()
                ->cursor()
                ->each(function($model){
                    $model->restore();
                    info("restore was commited for model query " . $model->identifyYourself());
                    $model->update(["reason_deleted" => null]);
                });
            }
            return $builder;
        });
    }

    protected function addIncludeTrashed(Builder $builder)
    {
        $builder->macro('includeTrashed', function (Builder $builder) {
            if($builder->getModel()->canBeSoftDeleted())
            {
                return $builder->withTrashed();
            }
            return $builder;
        });
    }
    
    protected function addOnlyIncludeTrashed(Builder $builder)
    {
        $builder->macro('onlyIncludeTrashed', function (Builder $builder) {
            if($builder->getModel()->canBeSoftDeleted())
            {
                return $builder->onlyTrashed();
            }
            return $builder;
        });
    }

    
}
