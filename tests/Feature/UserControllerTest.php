<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession(["user" => "abdul"])
            ->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post("/login", [
            "user" => "abdul",
            "password" => "rahasia",
        ])->assertRedirect("/")
            ->assertSessionHas("user", "abdul");
    }
    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession(["user" => "abdul"])
            ->post("/login", [
                "user" => "abdul",
                "password" => "rahasia",
            ])->assertRedirect("/");
    }
    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post("/login", [
            "user" => "salah",
            "password" => "salah",
        ])->assertSeeText("User or password is wrong");
    }
    public function testLogout()
    {
        $this->withSession([
            "user" => "abdul",
        ])->post("/logout", )
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post("/logout", )
            ->assertRedirect("/");
    }

}
