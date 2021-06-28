<?php

namespace App\Http\Resources;

use DB;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            "id" => $this->id,
            "avatarImage" => new ImageResource($this->whenLoaded('avatarImage')),
            "coverImage" => new ImageResource($this->whenLoaded('coverImage')),
            "account" => new UserResource($this->whenLoaded('account')),
            "username" => $this->username,
            'followers' => ProfileResource::collection($this->whenLoaded('followers')),
            'followings' => ProfileResource::collection($this->whenLoaded('followings')),
            'followers_count' => $this->followers_count ?? new MissingValue,
            'followings_count' => $this->followings_count ?? new MissingValue,
            'following' => $this->following,
            'settings' => new ProfileSettingsResource($this->whenLoaded('settings')),
            'url' => $this->url,
            'created_at' => $this->created_at ?? new MissingValue,
            'for_page_created_at' => $this->for_page_created_at ?? new MissingValue,
        ];
        return $resource;
    }
}
