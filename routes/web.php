<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;








// anything that does NOT start with "storage/" (which is where we store videos & images)
// will be mapped to vue routers

//$i = imagecreatefrompng('D:\Users\MCS\Downloads\1044147.png');
//imagewebp($i, "C:\Users\me\Pictures\Camera Roll\out.webp");
Auth::routes();
