<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpPermissionException;
use App\Http\Resources\PostResource;
use App\Http\StatusCodes;
use App\Models\Community;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return view('post.show')->with($post);
    }
    public function create(Request $request)
    {
        return view('post.create');
    }
    public function storeProfilePost(Request $request)
    {
        $post = Post::make($request->all());
        $post->author()->associate(Profile::current());
        $post->pageable()->associate(Profile::current());
        $post->save();
        return response()->redirectTo($post->url);
    }
    public function storeCommunityPost(Request $request, Community $community)
    {
        if($community->allowsCurrent(config('permissions.can-create-posts')))
        {
            $post = Post::make($request->all());
            
            $post->author()->associate(Profile::current());
            $post->pageable()->associate($community);
            $post->save();
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
