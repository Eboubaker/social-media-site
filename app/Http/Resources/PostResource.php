<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Log;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author' => new ProfileResource($this->whenLoaded('author')),
            'title' => $this->title,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'commentsCount' => $this->comments->count(),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'views' => LikeResource::collection($this->whenLoaded('likes')),
            'createdAt' => $this->created_at->diffForHumans(),
            'updatedAt' => $this->updated_at,
        ];
    }
}
