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
      //speciality //users ,"page"=>1,"limit"=>10
        $route=route('searchmedecin.api',["gouvernorat" => "",
        "speciality" => "Cardiologue",
        "name" => "first_name2",

    ]);
        $response = $this->json('GET', $route);

        $content = json_decode($response->getContent());
          dd($content);  
        $response->assertStatus(200);
    }
}
