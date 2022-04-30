<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register()
    {
        //$app_url = env('APP_URL');
        ////post
       /*
       name, email (which has to be unique), password, and password_confirmation
       */
        $route=route('register.api',["name" => "test",
        "email" => "email.test@gmail.com", "password" => "password",
        "password_confirmation" => "password"

    ]);
        $response = $this->json('POST', $route);

        

        $content = json_decode($response->getContent());
        dd($content);
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
