<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;








// anything that does NOT start with "storage/" (which is where we store videos & images)
// will be handled by vue routers
Route::get('/{any}', function () {
//    return view('welcome');
    return  PostResource::collection(Comment::all());
})->where('any', '^(?!storage\/).*');
