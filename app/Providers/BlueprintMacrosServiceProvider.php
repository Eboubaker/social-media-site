<?php

namespace App\Providers;

use App\DataBase\Trigger\TriggerFacade as TriggerSchema;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use Illuminate\Support\Reflector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionObject;

class BlueprintMacrosServiceProvider extends ServiceProvider
{
    public static array $triggers = [];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro("cascadeForeignKeysWithTriggers", function($columns){
            /** @var Blueprint $this */
            $childTable = $this->getTable();
            $commands = array_filter($this->commands, function($c){
                return $c instanceof ForeignKeyDefinition;
            });
            $commands = array_map(function($fk){
                $attr = (new ReflectionObject($fk))->getProperty('attributes');
                $attr->setAccessible(true);
                $fk->attrs = $attr->getValue($fk);
                return $fk;
            }, $commands);
            $columns = !is_array($columns) ? func_get_args() : $columns;
            foreach($columns as $column)
            {
                $fkcommand = head(array_filter($commands, function($fk) use ($column){
                    return $fk->attrs['columns'][0] === $column;
                })) ?? null;
                if(!$fkcommand)
                    throw new Exception("column $column was not found in table blueprint");
                $parentTable        = $fkcommand->attrs['on'];
                $foreignKeyName     = $fkcommand->attrs['columns'][0];
                $parentTablePrimary = $fkcommand->attrs['references'];
                BlueprintMacrosServiceProvider::$triggers[] = ['table' => $parentTable, 'migration' => function() use($childTable, $foreignKeyName, $parentTablePrimary, $parentTable){
                    $name = "$parentTable.before_delete_cascade_${childTable}";
                    printf("Creating Trigger: $name\r\n");
                    TriggerSchema::create("`$name`")
                        ->on($parentTable)
                        ->statement(function () use ($childTable, $foreignKeyName, $parentTablePrimary) {
                            return "\nDELETE FROM `$childTable` WHERE `$foreignKeyName`=OLD.`$parentTablePrimary`;\n";
                        })
                        ->before()
                        ->delete();
                }];
            }
            return $this;
        });
        Blueprint::macro("cascadeMorphsWithTriggers", function(array $morphs){
            /** @var Blueprint $this */
            $childTable = $this->getTable();
            if(!isset($morphs['models']))
            {
                $morphs = ['models' => $morphs];
            }
            if(!is_array($morphs['models']))
            {
                $morphs['models'] = [$morphs['models']];
            }
            $morphs['relation'] = $morphs['relation'] ?? Str::singular($childTable).'able';
            $id   = $morphs['id']   ?? $morphs['relation'].'_id';
            $type = $morphs['type'] ?? $morphs['relation'].'_type';
            
            foreach ($morphs['models'] as $model) {
                /** @var Model $instance */
                $instance = new $model;
                $parentPrimary = $instance->getKeyName();
                $parentMorphName = str_replace('\\', '\\\\', $instance->getMorphClass());
                $parentTable = $instance->getTable();
                BlueprintMacrosServiceProvider::$triggers[] = ['table' => $parentTable, 'migration' => function() use($childTable, $parentTable, $parentPrimary, $parentMorphName, $id, $type, $morphs){
                    $name = "$parentTable.before_delete_cascade_".Str::singular($parentTable)."_".$morphs['relation'].'s';
                    printf("Creating Trigger: $name\r\n");
                    TriggerSchema::create("`$name`")
                        ->on($parentTable)
                        ->statement(function () use($childTable, $id, $type, $parentMorphName, $parentPrimary){
                            return "\nDELETE FROM `$childTable` WHERE `$id`=OLD.`$parentPrimary` AND `$type`='$parentMorphName' ;\n";
                        })
                        ->before()
                        ->delete();
                }];
            }
            return $this;
        });
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
