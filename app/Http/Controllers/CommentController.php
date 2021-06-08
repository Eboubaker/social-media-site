<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpInternalServerErrorException;
use App\Exceptions\HttpPermissionException;
use App\Http\StatusCodes;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Comment $comment)
    {
        return view('comment.show', compact($comment));
    }
    public function redirectToPage(Comment $comment)
    {
        return redirect($comment->url);
    }
    public function storeComment(Request $request, Post $post)
    {
        $comment = Comment::make($request->all())
        ->commentor()
        ->associate(Profile::current());
        if($post->pageable instanceof Community)
        {
            $community = $post->pageable;
            if($community->allowsCurrent(config('permissions.communities.can-comment-on-posts')))
            {
                $comment = $post->comments()->save($comment);
            }else{
                throw new HttpPermissionException;
            }
        }else if($post->pageable instanceof Profile)
        {
            $profile = $post->pageable;
            if($profile->allowsCurrent(config('permissions.profile.can-comment')))
            {
                $comment = $post->comments()->save($comment);
            }else{
                throw new HttpPermissionException;
            }
        }
        $comment = $post->comments()->save($comment);
        if ($comment && $comment->exists) 
        {
            return redirect($comment->url);
        }
        throw new HttpInternalServerErrorException;
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $post = $comment->ancestorCommentable;

        $reply = Comment::make($request->all())
        ->commentor()
        ->associate(Profile::current());
        if($post->pageable instanceof Community)
        {
            $community = $post->pageable;
            if($community->allowsCurrent(config('permissions.communities.can-reply-on-comments')))
            {
                $reply = $comment->comments()->save($reply);
            }else{
                throw new HttpPermissionException;
            }
        }else if($post->pageable instanceof Profile)
        {
            $profile = $post->pageable;
            if($profile->allowsCurrent(config('permissions.profile.can-comment')))
            {
                $reply = $comment->comments()->save($reply);
            }else{
                throw new HttpPermissionException;
            }
        }
        $reply = $comment->comments()->save($reply);
        if ($reply && $reply->exists) 
        {
            return response(status:StatusCodes::HTTP_CREATED);
        }
        throw new HttpInternalServerErrorException;
    }
    public function update(Request $request, Comment $comment)
    {
        if($comment->commentor()->is(Profile::current()))
        {
            // TODO: security issue
            $comment->update($request->all());
            return response(status:StatusCodes::HTTP_NO_CONTENT);
        }
        throw new HttpPermissionException;
    }
}
