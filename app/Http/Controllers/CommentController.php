<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpInternalServerErrorException;
use App\Exceptions\HttpPermissionException;
use App\Http\Resources\CommentResource;
use App\Http\StatusCodes;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Image;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Video;
use App\Rules\AttachementRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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


    private function storeWithAttachements(Request $request, Comment $comment, Model $commentable)
    {
        $parser = new AttachementRule();
        Validator::make($request->all(), [
            'attachements.*' => $parser
        ])->validate();
        DB::beginTransaction();
        try{
            $comment->save();
            $pageable = $comment->post->pageable;
            
            foreach($parser->getModels() as $attachement)
            {
                if($pageable instanceof Community && $attachement instanceof Video && $pageable->allowsCurrent(config('permissions.communities.can-attach-videos-to-own-comment')))
                {
                    throw ValidationException::withMessages(['attachements' => 'You are not allowed to comment videos to this community']);
                }
                if($pageable instanceof Community && $attachement instanceof Image && $pageable->allowsCurrent(config('permissions.communities.can-attach-images-to-own-comment')))
                {
                    throw ValidationException::withMessages(['attachements' => 'You are not allowed to comment videos to this community']);
                }
                $attachement->attacheable()->associate($comment);
                $attachement->save();
            }
            DB::commit();
        }catch(\Throwable $e)
        {
            $comment->treeForceDelete();
            DB::rollBack();
            throw $e;
        }
        $comment->likes_count = 0;
        $comment->replies_count = 0;
        $comment->is_liked = false;
        return $comment;
    }


    public function storeComment(Request $request, Post $post)
    {
        if($post->pageable instanceof Community && ! $post->pageable->allowsCurrent(config('permissions.communities.can-comment-on-posts')))
        {
            throw new HttpPermissionException("You don't have permission to comment on this community");
        }else if($post->pageable instanceof Profile && ! $post->pageable->allowsCurrent(config('permissions.profile.can-comment'))){
            throw new HttpPermissionException("You don't have permission to comment on this community");
        }
        $comment = Comment::make($this->validated($request->all()))
        ->commentor()->associate(Profile::current())
        ->commentable()->associate($post)
        ->post()->associate($post);
        $comment = $this->storeWithAttachements(request(), $comment, $post);
        if ($comment && $comment->exists) 
        {
            return new JsonResponse(new CommentResource($comment), StatusCodes::HTTP_CREATED);
        }
        throw new HttpInternalServerErrorException;
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $post = $comment->post;
        $reply = Comment::make($this->validated($request->all()))
        ->commentor()->associate(Profile::currentRelation('profileImage')->first())
        ->commentable()->associate($comment)
        ->post()->associate($post);
        if($post->pageable instanceof Community)
        {
            $community = $post->pageable;
            if($community->allowsCurrent(config('permissions.communities.can-reply-to-comments')))
            {
                $reply = $comment->comments()->save($reply);
            }else{
                throw new HttpPermissionException;
            }
        }else if($post->pageable instanceof Profile)
        {
            $profile = $post->pageable;
            if($profile->allowsCurrent(config('permissions.profiles.can-comment')))
            {
                $reply = $comment->comments()->save($reply);
            }else{
                throw new HttpPermissionException;
            }
        }
        $reply->commentable()->associate($comment);
        $reply = $this->storeWithAttachements($request, $reply, $comment);
        if ($reply->exists) 
        {
            return new JsonResponse(new CommentResource($reply), StatusCodes::HTTP_CREATED);
        }
        throw new HttpInternalServerErrorException;
    }

    public function loadReplies(Comment $comment)
    {
        $post = $comment->post;
        if($post->pageable instanceof Community && ! $post->pageable->allowsCurrent(config('permissions.communities.can-view-posts'))
            || $post->pageable instanceof Profile && ! $post->pageable->allowsCurrent(config('permissions.profiles.can-view-posts'))
        )
        {
            throw new HttpPermissionException;
        }
        $skip = request('skip') ?: 0;
        $limit = request('limit') ?: 5;
        $comments = $comment
                    ->replies()
                    ->includeIsLikedAttribute(Profile::currentRelation()->first('id')->id)
                    ->with(['commentor', 'commentor.profileImage', 'images', 'videos'])
                    ->withCount(['likes', 'replies'])
                    ->skip($skip)
                    ->limit($limit)
                    ->get();
        return CommentResource::collection($comments);
    }

    public function update(Request $request, Comment $comment)
    {
        if($comment->commentor()->is(Profile::current()))
        {
            $comment->update($this->validated($request->all()));
            return response(status:StatusCodes::HTTP_NO_CONTENT);
        }
        throw new HttpPermissionException;
    }


    public function validated(array $data)
    {
        $validated = Validator::make(data:$data, rules:[
                'body' => ['max:10000'],
            ])->validate();
        if(empty(request('body')) && request()->files->get('attachements')->count() === 0)
        {
            throw ValidationException::withMessages(['comment' => 'comment cant be empty!']);
        }
        return $validated;
    }
}
