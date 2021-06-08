<?php

namespace Tests\Feature;

use App\Http\StatusCodes;
use App\Models\Comment;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPermission;
use App\Models\CommunityRole;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentManagementTest extends TestCase
{

    public function test_non_member_can_comment_on_community_posts_when_community_gives_permissions()
    {
        $user = User::factory()->hasProfiles(1)->create();
        $profile = $user->profiles->first();
        /** @var Community $community */
        $community = $profile->ownedCommunities()->save(Community::factory()->make());
        $role = CommunityRole::create(['name' => __FUNCTION__]);
        $role->permissions()->saveMany([
            CommunityPermission::find(config('permissions.communities.can-comment-on-posts'))
        ]);
        $community->visitorRole()->associate($role)->save();
        $post = $community->posts()->save(Post::factory()->withAuthor($profile)->make());
        
        $response = $this->post(route('post.storeComment', $post->getKey()),[
            'body' => __FUNCTION__
        ]);
        $this->assertDatabaseHas('comments', 
            ['body' => __FUNCTION__] + 
            $post->getMorphConstraints('commentable')
        );
        $comment = Comment::where('body', __FUNCTION__)->first();
        $response->assertRedirect($comment->url);
        return $comment;
    }
    public function test_comment_can_be_updated()
    {
        $comment = $this->test_non_member_can_comment_on_community_posts_when_community_gives_permissions();
        $this->actingAs($comment->commentor->account);
        $response = $this->post(route('comments.update', $comment->getKey()),[
            'body' => 'he changed me :('
        ]);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->getKey(),
            'body' => 'he changed me :('
        ]);
        $response->assertStatus(StatusCodes::HTTP_NO_CONTENT);
    }
    public function test_non_member_cant_comment_on_community_posts_when_community_gives_member_only_permissions()
    {
        $user = User::factory()->hasProfiles(1)->create();
        $profile = $user->profiles->first();
        /** @var Community $community */
        $community = $profile->ownedCommunities()->save(Community::factory()->make());
        CommunityMember::create([
            'profile_id' => $this->currentProfile->getKey(),
            'community_id' => $community->getKey(),
            'role_id' => CommunityRole::OWNER_ROLE_ID
        ]);
        $role = CommunityRole::create(['name' => __FUNCTION__]);
        $role->permissions()->saveMany([
            // no commenting permissions
        ]);
        
        $community->visitorRole()->associate($role)->save();
        $post = $community->posts()->save(Post::factory()->withAuthor($profile)->make());
        $this->loginWithProfile();
        $response = $this->post(route('post.storeComment', $post->getKey()),[
            'body' => __FUNCTION__
        ]);
        
        $this->assertDatabaseMissing('comments', 
            ['body' => __FUNCTION__] + 
            $post->getMorphConstraints('commentable')
        );
        $comment = Comment::where('body', __FUNCTION__)->first();
        $response->assertStatus(StatusCodes::HTTP_FORBIDDEN);
    }
}
