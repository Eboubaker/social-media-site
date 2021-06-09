<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'author' => new ProfileResource($this->whenLoaded('author')),
            'comments' => self::collection($this->whenLoaded('comments')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'commentsCount' => $this->comments->count(),
            'body' => $this->body,
            'createdAt' => $this->created_at->diffForHumans(),
            'updatedAt' => $this->updated_at->diffForHumans(),
        ];
    }
}
