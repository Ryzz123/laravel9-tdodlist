<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "febri"
        ])->get('/login')
            ->assertRedirect("/");
    }


    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "febri",
            "password" => "rahasia"
        ])->assertRedirect('/')
            ->assertSessionHas("User", "febri");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "febri"
        ])->post('/login', [
            "user" => "febri",
            "password" => "rahasia"
        ])->assertRedirect('/');
    }


    public function testValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "wrong",
            "password" => "wrong"
        ])
            ->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "febri"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("User");
    }

    public function testLogOutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }

}
