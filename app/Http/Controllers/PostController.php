<?php

namespace App\Http\Controllers;

use App\Exceptions\EmptyRequestParameterException;
use App\Exceptions\RequestParameterNotFoundException;
use App\Http\Collectors\PostCollector;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function storeProfilePost(Request $request, Post $post)
    {
        $post->author()->associate(Profile::current());
        $post->pageable()->associate(Profile::current());
        $post->save();
        return response()->redirectTo($post->url);
    }
    public function destroy(Post $post)
    {
        if(DB::transaction(fn()=>$post->delete()))
        {
            return response()->json(["message" => "post was deleted"]);
        }
        return response()->json(["message" => "error"], 500);
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
        if($post->pageable instanceof Community)
        {
            return redirect(route('community-post.show', [$post->pageable->name, $post->slug]));
        }else if($post->pageable instanceof Profile){
            return redirect(route('profile-post.show', [$post->pageable->username, $post->slug]));
        }
    }
}
