<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpPermissionException;
use App\Http\Resources\PostResource;
use App\Http\StatusCodes;
use App\Models\Community;
use App\Models\Image;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Video;
use App\Rules\AttachementRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function show($pageable, Post $post)
    {
        return view('post.show')->with($post);
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
        $post->author()->associate(Profile::current());
        $post->pageable()->associate(Profile::current());
        $post = $this->storeWithAttachements($request, $post, Profile::current());
        return response()->redirectTo($post->url);
    }
    private function storeWithAttachements(Request $request, Post $post, Model $pageable)
    {
        info(var_export($request->files->get('attachements')));
        $attachementsParser = new AttachementRule($pageable);
        Validator::make($request->all(), [
            'attachements.*' => [$attachementsParser] 
        ])->validate();
        $parsedFiles = $attachementsParser->getParsed();
        DB::beginTransaction();
        try{
            $post->save();
            foreach($parsedFiles as $attachement)
            {
                /**
                 * @var Image|Video $instance
                 */
                $instance = $attachement['model']::make(
                    collect($attachement)->forget(['model', 'path'])->all()
                );
                $instance->temporaryFileLocation = $attachement['path'];
                $instance->imageable()->associate($post);
                $instance->save();
            }
            DB::commit();
        }catch(\Throwable $e)
        {
            DB::rollBack();
            throw $e;
        }
        return $post;
    }
    public function storeCommunityPost(Request $request, Community $community)
    {
        if($community->allowsCurrent(config('permissions.communities.can-create-posts')))
        {
            $post = Post::make([
                'title' => $request->get('title'),
                'body' => $request->get('body'),
            ]);
            $post->author()->associate(Profile::current());
            $post->pageable()->associate($community);
            $post = $this->storeWithAttachements($request, $post, $community);
            return response()->redirectTo($post->url);
        }
        throw new HttpPermissionException;
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
        if(DB::transaction(fn()=>$post->update($request->all())))
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
    
}
