<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class AuthAdminTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_authadmin()
    {

        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);



        $response->assertStatus(200);
    }
}
