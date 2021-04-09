<?php

namespace App\Http\Controllers;

use App\Exceptions\EmptyRequestParameterException;
use App\Exceptions\RequestParameterNotFoundException;
use App\Http\Collectors\PostCollector;
use App\Http\Resources\PostResource;
use App\Models\Post;
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
    public function store(Request $request)
    {
        $exception = null;
        if(!$request->has('body'))
        {
            $exception = new RequestParameterNotFoundException("body parameter does not exist");
        }
        if(empty($request->get('body')))
        {
            $exception = new EmptyRequestParameterException("empty body parameter");
        }
        if($exception)
        {
            report($exception);
            return response()->json(["message" => "invalid request"], 400);
        }
        $post = auth('api')->user()->activeProfile->posts()->create(["content" => ["body" => $request->get('body')]]);
        return response()->json((new PostResource($post))->toJson());
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
}
