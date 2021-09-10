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
        $resource = [
            'id' => $this->id,
            'author' => new ProfileResource($this->whenLoaded('author')),
            'title' => $this->title,
            'body' => $this->body,
            'pageable_type' => str_replace('App\Models\\', '', $this->pageable_type),
            'pageable' => $this->whenLoaded('pageable', function () {
                if ($this->pageable instanceof Community) {
                    return new CommunityResource($this->pageable);
                } elseif ($this->pageable instanceof Profile) {
                    return new ProfileResource($this->pageable);
                }
                return new MissingValue;
            }),
            'notifications_on' => false,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'views' => ViewResource::collection($this->whenLoaded('likes')),
            'comments_count' => $this->comments_count,
            'likes_count' => $this->likes_count,
            'views_count' => $this->views_count,
            'commentsOpen' => $this->author_id != Profile::current_id() && $this->comment_count > 0,
            'createdAt' => $this->created_at->diffForHumans(),
            'updatedAt' => $this->updated_at,
            'is_liked' => $this->is_liked ? true : false,
        ];
        return $resource;
    }
}
