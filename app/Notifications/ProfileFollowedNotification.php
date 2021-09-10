<?php

namespace App\Notifications;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProfileFollowedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     * @param Follow $follow
     * @return void
     */
    public function __construct(public Profile $follower)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(Profile $notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_avatarImage' => $this->follower->avatarImage->url,
            'follower_username' => $this->follower->username,
        ];
    }
}
