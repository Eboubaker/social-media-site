<?php

namespace Tests;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    
    public function loginWithProfile():Profile
    {
        $user = User::factory()->hasProfiles(1)->create();
        $this->actingAs($user);
        return $user->profiles->first();
    }
}
