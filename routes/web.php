<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;








// anything that does NOT start with "storage/" (which is where we store videos & images)
// will be mapped to vue routers
Route::get('/{any}', function () {
   return view('auth.login');
//     return  PostResource::collection(Post::inRandomOrder()->limit(100)->get());
})->where('any', '^(?!api\/).*');
