<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationSystemTest extends DuskTestCase
{
    use DatabaseTransactions;
    
    public function test_visitor_can_register()
    {
        $this->withoutExceptionHandling();
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register'))
            ->type('phone_number', '0797921307')
            ->type('password', 'RRR%%%54ss')
            ->type('password_confirmation', 'RRR%%%54ss')
            ->type('username', 'thatoneguy')
            ->type('birthDate', '01022021')
            ->press('Register')
            ->assertPathIs('/');
        });
        $this->assertDatabaseHas('users', [
            "email" => 'newuser@gmail.com'
        ]);
    }
}
