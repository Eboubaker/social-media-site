<?php

namespace App\Http\Controllers;

use App\Events\PostLiked;
use App\Http\StatusCodes;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function likePost(Post $post)
    {
        if($post->likes()->where('liker_id', Profile::current_id())->exists())
        {
            return response(status:StatusCodes::HTTP_EXPECTATION_FAILED);
        }
        Like::create(
            ['liker_id' => Profile::current_id()] +
            $post->getMorphConstraints('likeable')
        );
        event(PostLiked::class, $post, Profile::current());
        return response(status:StatusCodes::HTTP_CREATED);
    }
    public function unlikePost(Post $post)
    {
        if(!$post->likes()->where('liker_id', Profile::current_id())->forceDelete())
        {
            return response(status:StatusCodes::HTTP_EXPECTATION_FAILED);
        }
        return response(status:StatusCodes::HTTP_NO_CONTENT);
    }

    public function likeComment(Comment $comment)
    {
        if($comment->likes()->where('liker_id', Profile::current_id())->exists())
        {
            return response(status:StatusCodes::HTTP_EXPECTATION_FAILED);
        }
        Like::create(
            $comment->getMorphConstraints('likeable') +
            ['liker_id' => Profile::current_id()]
        );
        return response(status:StatusCodes::HTTP_CREATED);
    }
    public function unlikeComment(Comment $comment)
    {
        if(!$comment->likes()->where('liker_id', Profile::current_id())->forceDelete())
        {
            return response(status:StatusCodes::HTTP_EXPECTATION_FAILED);
        }
        return response(status:StatusCodes::HTTP_NO_CONTENT);
    }
}
