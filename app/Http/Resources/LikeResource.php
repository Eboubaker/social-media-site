<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'liker' => new ProfileResource($this->whenLoaded('liker')),
            'likedAt' => $this->liked_at->diffForHumans()
        ];
    }
}
