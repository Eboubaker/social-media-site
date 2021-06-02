<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommunityManagementTest extends TestCase
{
    use DatabaseTransactions;


    private function loginWithProfile():Profile
    {
        $user = User::factory()->hasProfiles(1)->create();
        $this->actingAs($user);
        return $user->profiles->first();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_community_can_be_created()
    {
        $profile = $this->loginWithProfile();
        
        $response = $this->post(route('community.store'), [
            'name' => 'test',
            'description' => 'a good community'
        ]);
        $response->assertRedirect(route('community.show', 'test'));
        $this->assertDatabaseHas('communities', [
            'name' => 'test',
            'description' => 'a good community'
        ]);
    }
    public function test_community_can_be_shown()
    {
        $profile = $this->loginWithProfile();
        $response = $this->post('/community', [
            'name' => 'test',
            'description' => 'a good community'
        ]);
        $response = $this->get(route('community.show', 'test'));
        $response->assertStatus(200);
    }
    public function test_community_can_be_updated_by_owner()
    {
        $profile = $this->loginWithProfile();
        $response = $this->post('/community', [
            'name' => 'test',
            'description' => 'a good community'
        ]);
        $c = Community::factory()->create([
            'owner_id' => $profile->id,
            'default_role_id' => 1
        ]);
        $m = $c->members()->save(CommunityMember::make([
            'profile_id' => $profile->id,
            'role_id' => 2
        ]));
        $response = $this->put(route('community.update', $c->getKey()),[
            'current_name' => $c->name,
            'name' => 'i-changed-it',
            'description' => $c->description
        ]);
        $response->assertRedirect(route('community.show', 'i-changed-it'));
    }
    public function test_community_can_not_be_updated_by_non_owner()
    {
        $community = Community::random();
        $profile = Profile::where('id', '!=', $community->owner->getKey())->first();
        $this->actingAs($profile->account);
        $response = $this->put(route('community.update', $community->getKey()), [
            'current_name' => $community->name,
            'name' => 'i-changed-it',
            'description' => $community->description
        ]);
        $response->assertStatus(403);
    }
}
