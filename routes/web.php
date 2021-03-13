<?php

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// anything that does NOT start with "storage/" (which is where we store videos & images)
// will be mapped to vue routers

Route::get('/{any}', function () {
//    return view('welcome');
    return  PostResource::collection(Post::with('comments')->whereHas('images')->get())->response()->header('Content-Type', 'application/json');
})->where('any', '^(?!storage\/).*');
