<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->{Post::PKEY},
            'author' => new AccountResource($this->profileable->account),
            'content' => $this->content,
            'comments' => CommentResource::collection($this->whenPivotLoaded('commentables','comment')),
            'images' => ImageResource::collection($this->whenPivotLoaded('images','images')),
            'videos' => VideoResource::collection($this->whenPivotLoaded('videos','videos')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
