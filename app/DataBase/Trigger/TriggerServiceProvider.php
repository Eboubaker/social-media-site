<?php

namespace App\DataBase\Trigger;

use Illuminate\Support\ServiceProvider;
use App\DataBase\Trigger\Schema\MySqlBuilder;
use App\DataBase\Trigger\Command\TriggerMakeCommand;

class TriggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TriggerMakeCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton('trigger-builder', function () {
            return new MySqlBuilder(app('db.connection'));
        });
    }
}
