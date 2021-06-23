<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpPermissionException;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\StatusCodes;
use App\Models\Community;
use App\Models\Image;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Video;
use App\Rules\AttachementRule;
use App\Rules\PolymorphicRelationExists;
use DebugBar\DebugBar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Html\Elements\Input;

class PostController extends Controller
{
    public function show($pageable, Post $post)
    {
        return new PostResource($post->load(['images', 'videos', 'comments', 'likes', 'views']));
    }
    public function create(Request $request)
    {
        return view('post.create');
    }
    public function storeProfilePost(Request $request)
    {
        $post = Post::make([
            'title' => $request->get('title'),
            'body' => $request->get('body')
        ]);
        $author = Profile::currentRelation('profileImage')->first();
        $post->author()->associate($author);
        $post->pageable()->associate($author);
        $post = $this->storeWithAttachements($request, $post, $author);
        return new PostResource($post);
    }
    private function storeWithAttachements(Request $request, Post $post, Model $pageable)
    {
        $parser = new AttachementRule();
        Validator::make($request->all(), [
            'attachements.*' => $parser
        ])->validate();
        DB::beginTransaction();
        try{
            $post->save();
            foreach($parser->getModels() as $key => $attachement)
            {
                if($attachement instanceof Image)
                {
                    if($pageable instanceof Profile || $pageable instanceof Community && $pageable->allowsCurrent(config('permissions.communities.can-attach-images-to-own-post')))
                    {
                        $post->images()->save($attachement);
                    }else{
                        throw ValidationException::withMessages(["attachement-$key" => 'You are not allowed to post images to this community']);
                    }
                }else if($attachement instanceof Video)
                {
                    if($pageable instanceof Profile || $pageable instanceof Community && $pageable->allowsCurrent(config('permissions.communities.can-attach-videos-to-own-post')))
                    {
                        $post->videos()->save($attachement);
                    }else{
                        throw ValidationException::withMessages(["attachement-$key" => 'You are not allowed to post videos to this community']);
                    }
                }
            }
            DB::commit();
        }catch(\Throwable $e)
        {
            DB::rollBack();
            throw $e;
        }
        $post->views_count = 0;
        $post->comments_count = 0;
        $post->likes_count = 0;
        $post->setRelation('comments', new Collection);
        return $post;
    }
    public function storeCommunityPost(Request $request, Community $community)
    {
        if($community->allowsCurrent(config('permissions.communities.can-create-posts')))
        {
            $post = Post::make($this->validated($request->all()));
            $post->author()->associate(Profile::current());
            $post->pageable()->associate($community);
            $post = $this->storeWithAttachements($request, $post, $community);
            return $request->wantsJson() 
                    ? new JsonResponse(new PostResource($post), StatusCodes::HTTP_CREATED)
                    : response()->redirectTo($post->url);
        }else{
            throw new HttpPermissionException;
        }
    }
    public function destroy(Post $post)
    {
        if(DB::transaction(fn()=>$post->delete()))
        {
            return response()->json(["message" => "post was deleted"]);
        }
        return response()->json(["message" => "Unkown error occured"], StatusCodes::HTTP_EXPECTATION_FAILED);
    }
    public function update(Request $request, Post $post)
    {
        if(DB::transaction(fn()=>$post->update($this->validated($request->all()))))
        {
            // $post->refresh();
            return response()->json((new PostResource($post))->toArray($request));
        }
        return response()->json(["message" => "error"], 500);
    }

    public function redirectToPage(Post $post)
    {
        return redirect($post->url);
    }
    

    public function loadComments(Post $post)
    {
        if($post->pageable instanceof Community && ! $post->pageable->allowsCurrent(config('permissions.communities.can-view-posts'))
            || $post->pageable instanceof Profile && ! $post->pageable->allowsCurrent(config('permissions.profiles.can-view-posts'))
        )
        {
            throw new HttpPermissionException;
        }
        $skip = request('skip') ?: 0;
        $limit = request('limit') ?: 5;
        $comments = $post->comments()->with(['commentor', 'images', 'videos'])->withCount(['likes', 'replies'])->skip($skip)->limit($limit)->get();
        return CommentResource::collection($comments);
    }
    public function validated(array $data)
    {
        $validated = Validator::make(data:$data, rules:[
                'title' => ['max:255'],
                'body' => ['max:10000'],
            ])->validate();
        if(empty(request('title')) && empty(request('body')) && request()->files->get('attachements')->count() === 0)
        {
            throw ValidationException::withMessages(['post' => "post can't be empty"]);
        }
        return $validated;
    }
}
