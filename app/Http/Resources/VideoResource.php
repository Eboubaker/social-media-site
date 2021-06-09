<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'meta' => $this->meta,
            'createdAt' => $this->created_at,
        ];
    }
}
