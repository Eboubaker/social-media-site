<?php

namespace Tests\Feature;

use App\Http\StatusCodes;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeManagementTest extends TestCase
{
    public function test_post_can_be_liked()
    {
        /** @var Post $post */
        $post = $this->currentProfile->posts()->create([
            'title' => "me and you",
            "body" => "i wish i had somebody"
        ]);
        $this->loginWithProfile();
        $response = $this->post(route('post.like', $post->getKey()));
        $liker_id = $this->currentProfile->getKey();
        $this->assertDatabaseHas('likes',  
            compact('liker_id') +
            $post->getMorphConstraints('likeable')
        );
        $response->assertStatus(StatusCodes::HTTP_CREATED);
        return $post;
    }
    public function test_post_can_be_unliked()
    {
        $post = $this->test_post_can_be_liked();
        $liker_id = $this->currentProfile->getKey();
        $response = $this->post(route('post.unlike', $post->getKey()));
        $this->assertDatabaseMissing('likes',  
            compact('liker_id') +
            $post->getMorphConstraints('likeable')
        );
        $response->assertStatus(StatusCodes::HTTP_NO_CONTENT);
    }



    public function test_comment_can_be_liked()
    {
        /** @var Post $post */
        $post = $this->currentProfile->posts()->create([
            'title' => "me and you",
            "body" => "i wish i had somebody"
        ]);
        $this->loginWithProfile();
        $comment = $post->comments()->create([
            "commentor_id" => $this->currentProfile->getKey(),
            'body' => 'i am a comment'
        ]);
        $response = $this->post(route('comment.like', $comment->getKey()));
        $liker_id = $this->currentProfile->getKey();
        $this->assertDatabaseHas('likes',  
            compact('liker_id') +
            $comment->getMorphConstraints('likeable')
        );
        $response->assertStatus(StatusCodes::HTTP_CREATED);
        return $comment;
    }
    public function test_comment_can_be_unliked()
    {
        $comment = $this->test_comment_can_be_liked();
        $response = $this->post(route('comment.unlike', $comment->getKey()));
        $liker_id = $this->currentProfile->getKey();
        $this->assertDatabaseMissing('likes',  
            compact('liker_id') +
            $comment->getMorphConstraints('likeable')
        );
        $response->assertStatus(StatusCodes::HTTP_NO_CONTENT);
    }
}
