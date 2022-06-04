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
    public function test_search()
    {
      //speciality //users
        $route=route('search.api',["tableID" => "speciality"

    ]);
        $response = $this->json('GET', $route);

        

        $content = json_decode($response->getContent());
        dd($content);
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
