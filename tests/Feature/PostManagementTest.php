<?php

namespace Tests\Feature;

use App\Http\StatusCodes;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_visitor_can_post_on_community_with_permissions()
    {
        $this->withoutExceptionHandling();
        $community = $this->currentProfile->ownedCommunities()->save(Community::factory()->make());
        $community->refresh();
        // dd($community->exists);
        $this->loginWithProfile();
        $response = $this->post(route('community.posts.store', [$community->getKey()]), [
            'title' => "he cant handle it",
            "body" => "blaaa blaaaa"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "he cant handle it"
        ]);
        $post = Post::where('title', "he cant handle it")->first();
        $response->assertRedirect($post->url);
    }

    public function test_visitor_cant_post_on_community_with_private_permissions()
    {
        $role = CommunityRole::create([
            'name' => "visitor_cant_post_test"
        ]);
        
        $community = $this->currentProfile
        ->ownedCommunities()
        ->save(Community::factory()->make([
            'visitor_role_id' => $role->getKey()
        ]));
        $this->loginWithProfile();
        
        $response = $this->post(route('community.posts.store', [$community->getKey()]), [
            'title' => "he cant handle it",
            "body" => "blaaa blaaaa"
        ]);
        $this->assertDatabaseMissing('posts', [
            'title' => "he cant handle it"
        ]);
        $response->assertStatus(StatusCodes::HTTP_FORBIDDEN);
    }

    public function test_member_can_post_on_community_with_members_only_permission()
    {
        $community = $this->currentProfile
        ->ownedCommunities()
        ->save(Community::factory()->make());
        $community->visitorRole()->associate(CommunityRole::create([
            'name' => "visitor_cant_create_posts"
        ]))->save();// no permissions
        $community->refresh();
        $this->loginWithProfile();
        CommunityMember::create([
            "profile_id" => $this->currentProfile->getKey(),
            "community_id" => $community->getKey()
        ]);
        $response = $this->post(route('community.posts.store', [$community->getKey()]), [
            'title' => "he cant handle it",
            "body" => "blaaa blaaaa"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "he cant handle it"
        ]);
        $post = Post::where('title', "he cant handle it")->first();
        $response->assertRedirect($post->url);
    }

    public function test_profile_can_create_posts_on_his_own_page()
    {
        $this->withoutExceptionHandling();
        $this->post(route('profile.posts.store'), [
            'title' => "profile post is created",
            "body" => "blaaa blaaaa"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "profile post is created"
        ]);
    }
}
