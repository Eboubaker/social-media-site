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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_visitor_can_post_without_attachements_on_community_with_permissions()
    {
        $community = $this->currentProfile->ownedCommunities()->save(Community::factory()->make());
        $response = $this->post(route('community.posts.store', [$community->getKey()]), [
            'title' => "sample title",
            "body" => "blaaa blaaaa"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "sample title"
        ]);
        $post = Post::where('title', "sample title")->first();
        $response->assertRedirect($post->url);
    }
    public function test_visitor_can_post_with_image_on_community_with_permissions()
    {
        $community = $this->currentProfile->ownedCommunities()->save(Community::factory()->make());
        $path = Storage::disk('faker_images')->path(collect(Storage::disk('faker_images')->files())->random());
        $tmp = sys_get_temp_dir() . '\upload.png';
        copy($path, $tmp);
        $response = $this->post(route('community.posts.store', [$community->getKey()]), [
            'title' => "sample title",
            "body" => "this is a body sample",
            "attachements" => [
                new UploadedFile($tmp, "my best image.png", "image/png")
            ]
        ]);
        $this->assertDatabaseHas('posts', [
            'title' => "sample title"
        ]);
        $post = Post::where('title', "sample title")->first();
        $this->assertDatabaseHas('images',
            $post->getMorphConstraints('imageable')
        );
        
        $response->assertRedirect($post->url);
    }
    public function test_visitor_can_post_with_video_on_community_with_permissions()
    {
        $community = $this->currentProfile->ownedCommunities()->save(Community::factory()->make());
        $path = Storage::disk('faker_videos')->path(collect(Storage::disk('faker_videos')->files())->random());
        $tmp = sys_get_temp_dir() . '\upload.mp4';
        copy($path, $tmp);
        $response = $this->post(route('community.posts.store', [$community->getKey()]), [
            'title' => "sample title",
            "body" => "this is a body sample",
            "attachements" => [
                new UploadedFile($tmp, "my best image.mp4", "image/mp4")
            ]
        ]);
        $this->assertDatabaseHas('posts', [
            'title' => "sample title"
        ]);
        $post = Post::where('title', "sample title")->first();
        $this->assertDatabaseHas('videos',
            $post->getMorphConstraints('videoable')
        );
        
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
            'title' => "sample title",
            "body" => "this is a body sample"
        ]);
        $this->assertDatabaseMissing('posts', [
            'title' => "sample title"
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
            'title' => "sample title",
            "body" => "this is a body sample"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "sample title"
        ]);
        $post = Post::where('title', "sample title")->first();
        $response->assertRedirect($post->url);
    }

    public function test_profile_can_create_posts_on_his_own_page()
    {
        $this->withoutExceptionHandling();
        $this->post(route('profile.posts.store'), [
            'title' => "profile post is created",
            "body" => "this is a body sample"
        ]);
        
        $this->assertDatabaseHas('posts', [
            'title' => "profile post is created"
        ]);
    }
}
