<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'id' => $this->id,
            'url' => $this->url,
            'mime' => $this->mime,
            'createdAt' => $this->created_at,
        ];
    }
}
