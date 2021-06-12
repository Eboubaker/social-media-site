<?php

namespace App\Http\Resources;

use App\Models\Morphs\Profileable;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "firstName" => $this->whenLoaded('account', function () {
                return $this->account->first_name;
            }),
            "lastName" => $this->whenLoaded('account', function () {
                return $this->account->last_name;
            }),
            "username" => $this->username,
            'followers' => $this->whenLoaded('followers', function () {
                return ProfileResource::collection($this->followers);
            }),
            'followings' => $this->whenLoaded('followings', function () {
                return ProfileResource::collection($this->followings);
            }),
            'followings_count' => $this->whenLoaded('followings', function () {
                return $this->followings->count();
            }),
            'followers_count' => $this->whenLoaded('followers', function () {
                return $this->followers->count();
            }),
        ];
        if ( ! isset($resource['followers_count']) && $this->followers_count !== null) {
            $resource['followers_count'] = $this->followers_count;
        }
        if ( ! isset($resource['followings_count']) && $this->followings_count !== null) {
            $resource['followings_count'] = $this->followings_count;
        }
        return $resource;
    }
}
