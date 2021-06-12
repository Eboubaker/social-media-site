<?php

namespace App\Http\Resources;

use App\Models\Community;
use App\Models\Post;
use App\Models\Profile;
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
            'body' => $this->body,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'pageable' => $this->whenLoaded('pageable', function () {
                if ($this->pageable instanceof Community) {
                    return new CommunityResource($this->pageable);
                } elseif ($this->pageable instanceof Profile) {
                    return new ProfileResource($this->pageable);
                }
                return new MissingValue;
            }),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'commentsCount' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            }),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'views' => LikeResource::collection($this->whenLoaded('likes')),
            'createdAt' => $this->created_at->diffForHumans(),
            'updatedAt' => $this->updated_at,
        ];
    }
}
