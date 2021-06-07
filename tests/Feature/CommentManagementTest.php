<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Community;
use App\Models\CommunityPermission;
use App\Models\CommunityRole;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentManagementTest extends TestCase
{

    public function test_non_member_can_comment_on_community_posts_when_community_gives_permissions()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->hasProfiles(1)->create();
        $profile = $user->profiles->first();
        /** @var Community $community */
        $community = $profile->ownedCommunities()->save(Community::factory()->make());
        $role = CommunityRole::create(['name' => __FUNCTION__]);
        $role->permissions()->saveMany([
            CommunityPermission::find(config('permissions.can-create-posts'))
        ]);
        $community->visitorRole()->associate($role);
        $post = $community->posts()->save(Post::factory()->withAuthor($profile)->make());
        
        
        $response = $this->post(route('post.createComment', $post->getKey()),[
            'body' => 'i am a good comment'
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
    }
}
