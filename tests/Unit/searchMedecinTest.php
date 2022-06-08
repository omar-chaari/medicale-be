<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class SearchMedecinTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_searchmedecin()
    {
      //speciality //users
        $route=route('searchmedecin.api',["gouvernorat" => "Beja",
        "speciality" => "Cardiologue"

    ]);
        $response = $this->json('GET', $route);

        

        $content = json_decode($response->getContent());
        //dd($content);
        $response->assertStatus(200);
    }
}
