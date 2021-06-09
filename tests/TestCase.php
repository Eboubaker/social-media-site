<?php

namespace Tests;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    
    public User $loggedInUser;
    public Profile $currentProfile;

    public function loginWithProfile():Profile
    {
        $this->loggedInUser = User::factory()->hasProfiles(1)->create();
        $this->actingAs($this->loggedInUser);
        $this->currentProfile = $this->loggedInUser->profiles->first();
        return $this->currentProfile;
    }



    public function __construct(...$atts)
    {
        parent::__construct(...$atts);
        $this->afterApplicationCreated(function(){
            $this->withoutExceptionHandling();
            $this->loginWithProfile();
        });
    }
}
