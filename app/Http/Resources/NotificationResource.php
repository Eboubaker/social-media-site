<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->type === 'App\\Notifications\\ProfileFollowedNotification')
        {
            return [
                'id' => $this->id,
                'event' => 'NewFollower',
                'follower_username' => $this->data['follower_username'],
                'follower_avatarImage' => $this->data['follower_avatarImage'],
                'read' => $this->read_at !== null,
                'url' => route('profile.show', $this->data['follower_username']),
                'created_at' => $this->created_at->diffForHumans(syntax:true,short:true),
            ];
        }
        return null;
    }
}
