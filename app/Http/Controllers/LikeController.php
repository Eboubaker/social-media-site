<?php

namespace App\Http\Controllers;

use App\Http\StatusCodes;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;

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
        $post->likes()->where('liker_id', Profile::current_id())->forceDelete();
        return response(status:StatusCodes::HTTP_NO_CONTENT);
    }

    public function likeComment(Comment $comment)
    {
        Like::create(
            $comment->getMorphConstraints('likeable') +
            ['liker_id' => Profile::current_id()]
        );
        return is_object(Profile::current()->comments()->save($comment))
        ? response(status:StatusCodes::HTTP_CREATED)
        : abort(StatusCodes::HTTP_INTERNAL_SERVER_ERROR);
    }
    public function unlikeComment(Comment $comment)
    {
        $comment->likes()->where('liker_id', Profile::current_id())->forceDelete();
        return response(status:StatusCodes::HTTP_NO_CONTENT);
    }
}
