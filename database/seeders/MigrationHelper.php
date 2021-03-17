<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class MigrationHelper
{
    /**
     * @param Blueprint $table
     * @param Model $target
     * @param bool $onUpdateCascade
     * @param bool $onDeleteCascade
     * @return array index 0 = ForeignIdColumnDefinition index 1 = ForeignKeyDefinition
     */
    public static function addForeign(Blueprint $table, Model $target, $onUpdateCascade = true, $onDeleteCascade = true): array
    {
        $foreign = $target->getForeignKey();
        $column = null;
        if($target->getKeyType() === 'string')
            $column = $table->foreignUuid($foreign)->index();
        else
            $column = $table->foreignId($foreign)->index();
        $keydef = $table->foreign($foreign)
            ->references($target->getKeyName())
            ->on($target->getTable());
        if($onDeleteCascade)
            $keydef->cascadeOnDelete();
        if($onUpdateCascade)
            $keydef->cascadeOnUpdate();
        return [$column, $keydef];
    }
    public static function addTimeStamps(Blueprint $table, Model $target)
    {
        if(!empty($target::CREATED_AT))
            $table->timestamp($target::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
        if(!empty($target::UPDATED_AT))
            $table->timestamp($target::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
    }
}
