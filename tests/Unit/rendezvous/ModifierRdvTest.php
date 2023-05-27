<?php

namespace Tests\Unit\rendezvous;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class ModifierRdvTest extends TestCase
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
                "keys": {
                    "id": "9"
                },
                "form_data": {
                    "date_debut": "2023-05-18 12:00:00",
                    "state": "1",
                    "date_fin": "2023-05-18 12:30:00"
                }
            },
            "cmd": "email_confirm_rdv"
        }';
        
        
        $array = json_decode($json, true);
        
        $route=route('update-datatable.api',$array);
        //$response = $this->json('POST', $route);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', $route);

    

        

        //$content = json_decode($response->getContent());
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
