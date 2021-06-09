<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegistrationSystemTest extends TestCase
{


    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->afterApplicationCreated(function(){
            Auth::logout();
        });
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_visitor_can_register_with_email()
    {
        $response = $this->post(route('register'), [
            'firstName' => "Ahmed",
            'lastName' => "Dokka",
            'birthDate' => '2020/12/11',
            
            'username' => 'thatoneguy',
            'login' => 'testing@gmail.com',
            'password' => 'RRR%%%54ss',
            'password_confirmation' => 'RRR%%%54ss',
        ]);
        $this->assertDatabaseHas('users', [
            "email" => 'testing@gmail.com'
        ]);
        $response->assertRedirect(route('verification.notice', 'email'));
    }

    public function test_user_can_login_with_email()
    {
        $response = $this->post(route('register'), [
            'firstName' => "Ahmed",
            'lastName' => "Dokka",
            'birthDate' => '2020/12/11',
            
            'username' => 'thatoneguy',
            'login' => 'testing@gmail.com',
            'password' => 'RRR%%%54ss',
            'password_confirmation' => 'RRR%%%54ss',
        ]);
        Auth::logout();
        $response = $this->post(route('login'), [
            'login' => 'testing@gmail.com',
            'password' => 'RRR%%%54ss',
        ]);
        $this->assertNotNull(Auth::user());
    }
}
