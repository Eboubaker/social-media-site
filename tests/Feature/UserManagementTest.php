<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_visitor_can_register()
    {
        $this->visit(route('register'))
            ->type('newuser@gmail.com', 'email')
            ->type('RRR%%%54ss', 'password')
            ->type('RRR%%%54ss', 'confirm-password')
            ->type('thatoneguy', 'username')
            ->type('2021/01/01', 'birthDate')
            ->press('Register')
            ->assertPathIs('/');
    }
}
