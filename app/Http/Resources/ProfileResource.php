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
            "profileImage" => new ImageResource($this->whenLoaded('profileImage')),
            "coverImage" => new ImageResource($this->whenLoaded('coverImage')),
            "account" => new UserResource($this->whenLoaded('account')),
            "username" => $this->username,
            'followers' => ProfileResource::collection($this->whenLoaded('followers')),
            'followings' => ProfileResource::collection($this->whenLoaded('followings')),
            'followings_count' => $this->followers_count ?: new MissingValue,
            'followers_count' => $this->followings_count ?: new MissingValue,
            'settings' => new ProfileSettingsResource($this->whenLoaded('settings')),
            'url' => $this->url,
        ];
        return $resource;
    }
}
