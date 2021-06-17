<?php

namespace App\Http\Controllers;

use App\Http\StatusCodes;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function likePost(Post $post)
    {
        Like::create(
            ['liker_id' => Profile::current_id()] +
            $post->getMorphConstraints('likeable')
        );
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
        Like::create(
            $comment->getMorphConstraints('likeable') +
            ['liker_id' => Profile::current_id()]
        );
        return response(status:StatusCodes::HTTP_CREATED);
    }
    public function unlikeComment(Comment $comment)
    {
        $comment->likes()->where('liker_id', Profile::current_id())->forceDelete();
        return response(status:StatusCodes::HTTP_NO_CONTENT);
    }
}
