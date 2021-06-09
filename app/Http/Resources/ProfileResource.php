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
        return [
            "id" => $this->id,
            "profileImage" => new ImageResource($this->whenLoaded('profileImage')),
            "coverImage" => new ImageResource($this->whenLoaded('coverImage')),
            "firstName" => $this->first_name,
            "lastName" => $this->last_name
        ];
    }
}
