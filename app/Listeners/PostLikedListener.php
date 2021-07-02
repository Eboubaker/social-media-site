<?php

namespace App\Listeners;

use App\Events\PostLiked;
use App\Notifications\PostLikedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostLikedListener implements ShouldQueue
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
     * @param  PostLiked  $event
     * @return void
     */
    public function handle(PostLiked $event)
    {
        $event->post->notifiables()->each(function($notifiables) use($event){
            $notifiables->notify(new PostLikedNotification($event->post, $event->liker));
        });
        $event->post->author->notify(new PostLikedNotification($event->post, $event->liker));
    }
}
