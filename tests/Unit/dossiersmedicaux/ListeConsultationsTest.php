<?php

namespace Tests\Unit\dossiersmedicaux;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class ListeConsultationsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {

      
        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);

        $content = json_decode($response->getContent());
       
        $token = $content->token;

        $route = route('search-consulatation.api', [
            "patient" => 766,
            "limit" => 10,
            "offset" => 0,

        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('GET', $route);


        $content = json_decode($response->getContent());
        //  dd($content);  
        $response->assertStatus(200);
    }
 
}
