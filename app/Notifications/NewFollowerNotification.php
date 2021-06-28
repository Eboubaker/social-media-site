<?php

namespace App\Notifications;

use App\Models\Follow;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollowerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $follower_id;
    /**
     * Create a new notification instance.
     * @param Follow $follow
     * @return void
     */
    public function __construct($follower_id)
    {
        $this->follower_id = $follower_id;
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
    public function toArray($notifiable)
    {
        $follower = Profile::with('avatarImage')->find($this->follower_id);
        return [
            'follower_id' => $this->follower_id,
            'follower_avatarImage' => $follower->avatarImage->url,
            'follower_username' => $follower->username,
        ];
    }
}
