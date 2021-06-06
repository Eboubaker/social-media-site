<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PostManagementTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_visitor_can_post_on_community_with_permissions()
    {
        $community = $this->currentProfile->ownedCommunities()->save(Community::factory()->make());
        $this->loginWithProfile();
        $this->followingRedirects();
        $response = $this->post(route('community.posts.store', [$community->getKey()]), [
            'title' => "he cant handle it",
            "body" => "blaaa blaaaa"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "he cant handle it"
        ]);
        $post = Post::where('title', "he cant handle it")->first();
        $response->assertLocation($post->url);
    }

    public function test_visitor_cant_post_on_community_with_private_permissions()
    {

    }

    public function test_member_can_post_on_community_with_private_permissions()
    {

    }

    public function test_profile_can_create_posts_on_his_own_page()
    {
        $this->post(route('profile.posts.store', [$this->currentProfile->getKey()]), [
            'title' => "profile post is created",
            "body" => "blaaa blaaaa"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "profile post is created"
        ]);
    }
}
