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
      /*
{
    "first_name": "omar",
    "last_name": "chaari",
    "country": "",
    "speciality": "13",
    "verification": 0,
    "phone": "50100100",
    "governorate": "2",
    "email": "test-medical-app@test.com",
    "password": "test-medical-app@test.com",
    "password_confirmation": "test-medical-app@test.com",
    "address": "50 Rue Mohamed Elkhames"
}

      */
        $route=route('register.api',["first_name" => "Omar",
        "last_name"=> "Chaari",
        "speciality"=> "13",
        "verification" => 0,
        "phone" => "50000000",
        "governorate" => "2",
        "email" => "email.test-2@gmail.com", 
        "password" => "email.test-2@gmail.com",
        "password_confirmation" => "email.test-2@gmail.com",
        "address" => "50 Rue Mohamed Elkhames"

    ]);
        $response = $this->json('POST', $route);

        

        //$content = json_decode($response->getContent());
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
