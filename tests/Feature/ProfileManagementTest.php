<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{



    public function test_user_can_create_new_profile()
    {
        $user = User::factory()->hasProfiles(1)->create();
        $this->actingAs($user);

        $response = $this->post(route('profile.store'), [
            'username' => 'dummy_guy_221'
        ]);
        $user->reload();
        $this->assertEquals(2, $user->profiles->count());
        $profile = $user->profiles->skip(1)->first();
        $response->assertRedirect('/');
    }
    public function test_user_can_switch_profile()
    {
        $user = User::factory()->hasProfiles(2)->create();
        $this->actingAs($user);

        $old_active_profile = $user->profiles->first();
        $old_active_profile->update(["active" => true]);

        $switching_profile = $user->profiles()->skip(1)->first();
        
        $response = $this->post(route('profile.switch', $switching_profile->getKey()));
        $response->assertRedirect('/');
        $this->assertDatabaseHas('profiles',[
            $switching_profile->getKeyName() => $switching_profile->getKey(),
            'active' => true
        ]);
        $this->assertDatabaseHas('profiles',[
            $old_active_profile->getKeyName() => $old_active_profile->getKey(),
            'active' => false
        ]);
    }
}
