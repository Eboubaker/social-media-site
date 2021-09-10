<?php

namespace App\Listeners;

use App\Providers\BlueprintMacrosServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Queue\InteractsWithQueue;

class MigrationsEndedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $triggers = collect(BlueprintMacrosServiceProvider::$triggers);
        $triggers = $triggers->sortBy('table');
        foreach($triggers as $trigger)
        {
            $trigger['migration']();
        }
    }
}
