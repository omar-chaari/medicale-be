<?php

namespace Tests\Unit\rendezvous;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class AjoutRdvTest extends TestCase
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
            "data": {
                "form_data": {
                    "patient": "10",
                    "professional": 221,
                    "date_debut": "2023-05-20 14:30:00",
                    "date_fin": "2023-05-20 15:00:00",
                    "motif_consultation": ""
                }
            },
            "cmd": "email_nouveau_rdv"
        }';
        
        
        $array = json_decode($json, true);
        
        $route=route('insert-datatable.api',$array);
        //$response = $this->json('POST', $route);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', $route);

    

        

        //$content = json_decode($response->getContent());
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
