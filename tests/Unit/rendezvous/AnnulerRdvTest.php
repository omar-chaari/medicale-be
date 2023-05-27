<?php

namespace Tests\Unit\rendezvous;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class AnnulerRdvTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register()
    {
        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);

        $content = json_decode($response->getContent());

        $token = $content->token;


        $json = '{
            "table": "appointements",
            "where": [
                {
                    "id": "25"
                }
            ]
        }';
        
        
        $array = json_decode($json, true);
        
        $route=route('delete-datatable.api',$array);
        //$response = $this->json('POST', $route);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('DELETE', $route);

    

        

        //$content = json_decode($response->getContent());
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
