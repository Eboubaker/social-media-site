<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class MigrationHelper
{
    public static function addForeign(Blueprint $table, Model $target, $onUpdateCascade = true, $onDeleteCascade = true)
    {
        $foreign = $target->getForeignKey();
        if($target->getKeyType() === 'string')
            $table->foreignUuid($foreign)->index();
        else
            $table->foreignId($foreign)->index();
        $keydef = $table->foreign($foreign)
            ->references($target->getKeyName())
            ->on($target->getTable());
        if($onDeleteCascade)
            $keydef->cascadeOnDelete();
        if($onUpdateCascade)
            $keydef->cascadeOnUpdate();
    }
    public static function addTimeStamps(Blueprint $table, Model $target)
    {
        if(!empty($target::CREATED_AT))
            $table->timestamp($target::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
        if(!empty($target::UPDATED_AT))
            $table->timestamp($target::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
    }
}
