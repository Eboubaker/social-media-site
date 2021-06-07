<?php

namespace Tests\Feature;

use App\Http\StatusCodes;
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
        $this->assertDatabaseHas('communities', [
            'name' => 'test',
            'description' => 'a good community'
        ]);
        $response->assertRedirect(route('community.show', 'test'));
        
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
            'owner_id' => $profile->id
        ]);
        $m = $c->members()->create([
            'profile_id' => $profile->id,
            'role_id' => 2
        ]);
        $response = $this->put(route('community.update', $c->getKey()),[
            'name' => 'iChangedIt',
        ]);
        $response->assertRedirect(route('community.show', 'iChangedIt'));
    }
    public function test_community_can_not_be_updated_by_non_owner()
    {
        $community = Community::random();
        $profile = Profile::where('id', '!=', $community->owner->getKey())->first();
        $this->actingAs($profile->account);
        $response = $this->put(route('community.update', $community->getKey()), [
            'name' => 'iChangedIt'
        ]);
        $this->assertDatabaseMissing('communities',[
            'name' => 'iChangedIt'
        ]);
        $response->assertStatus(StatusCodes::HTTP_FORBIDDEN);
    }
}
