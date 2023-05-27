<?php

namespace Tests\Unit\rendezvous;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class ListeRdvTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_liste_rdv()
    {
        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);

        $content = json_decode($response->getContent());
       
        $token = $content->token;
        
        $route = route('list-datatable.api', [
            "tableID" => "appointements",
            "results_per_page" => 10,
            "page" => 0
        ]);

        
       
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('GET', $route);

    

        

        //$content = json_decode($response->getContent());
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
