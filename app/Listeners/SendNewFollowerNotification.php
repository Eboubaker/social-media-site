<?php

namespace App\Listeners;

use App\Events\NewFollowCreated;
use App\Notifications\NewFollowerNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewFollowerNotification implements ShouldQueue
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
     * @param  NewFollowCreated  $event
     * @return void
     */
    public function handle(NewFollowCreated $event)
    {
        
    }
}
