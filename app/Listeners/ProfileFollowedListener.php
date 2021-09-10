<?php

namespace App\Listeners;

use App\Events\ProfileFollowed;
use App\Models\Follow;
use App\Models\Profile;
use App\Notifications\ProfileFollowedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProfileFollowedListener implements ShouldQueue
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
    public function handle(Follow $event)
    {
        $event->profile->notify(new ProfileFollowedNotification($event->follower));
    }
}
