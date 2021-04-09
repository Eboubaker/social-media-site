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
            'id' => $this->{Post::PKEY},
            'author' => new ProfileResource(Post::find($this->{Post::PKEY})->profileable),
            'content' => $this->content,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'commentsCount' => $this->comments->count(),
            'createdAt' => $this->created_at->diffForHumans(),
            'updatedAt' => $this->updated_at,
        ];
    }
}
