<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationSystemTest extends DuskTestCase
{
    
    public function test_visitor_can_register_with_email()
    {
        User::where('email', 'testing@gmail.com')->firstOrNew()->doForceDelete();
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register'))
            ->type('firstName', "Ahmed")
            ->type('lastName', "Dokka")
            ->type('birthDate', '01022021')
            
            ->type('username', 'thatoneguy')
            ->type('login', 'testing@gmail.com')
            ->type('password', 'RRR%%%54ss')
            ->type('password_confirmation', 'RRR%%%54ss')
            ->press('Register')
            ->assertUrlIs(route('verification.notice', 'email'));
        });
        $this->assertDatabaseHas('users', [
            "email" => 'testing@gmail.com'
        ]);
    }
}
