<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationSystemTest extends DuskTestCase
{
    use DatabaseTransactions;
    
    public function test_visitor_can_register_with_email()
    {
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
            "phone" => '+213797921307'
        ]);
    }
}
