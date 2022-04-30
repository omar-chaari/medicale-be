<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login()
    {
        //$app_url = env('APP_URL');
        ////post
        $screenID="MAINT-146";
        $route=route('login.api',["screenID" => $screenID]);
        $response = $this->json('POST', $route);

        

        $content = json_decode($response->getContent());
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
