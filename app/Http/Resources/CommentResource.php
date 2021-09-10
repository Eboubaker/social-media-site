<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixins \App\Models\Comment
 */
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
        $resource = [
            'id' => $this->id,
            'body' => $this->body,
            'commentor' => new ProfileResource($this->whenLoaded('commentor')),
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
            'replies_count' => $this->replies_count,
            'likes_count' => $this->likes_count,
            'is_liked' => $this->is_liked,
            'post_id' => $this->post_id,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'createdAt' => $this->created_at->diffForHumans(syntax:true,short:true),
            'updatedAt' => $this->updated_at->diffForHumans(),
        ];
        return $resource;
    }
}
