<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class SearchTest extends TestCase
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
        $route=route('search.api',["tableID" => "users"

    ]);
        $response = $this->json('GET', $route);

        

        $content = json_decode($response->getContent());
        dd($content);
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
