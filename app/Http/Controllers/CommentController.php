<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storeComment(Request $request, Post $post)
    {
        
    }
    public function storeReply(Request $request, Comment $comment)
    {

    }
    public function update(Request $request, Comment $comment)
    {
        
    }
}
