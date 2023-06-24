<?php

namespace Tests\Unit\dossiersmedicaux;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class AjouterConsultationTest extends TestCase
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

        /*


        */
    
        $json = '{
            "professional": "189",
            "patient": "12",
            "date": "2023-06-14",
            "motif": "test",
            "notes": "test"
        }';
        
        $array = json_decode($json, true);
        

        $route = route('consultation-store.api', $array);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', $route);


        $content = json_decode($response->getContent());
        $response->assertStatus(201);

    }
 
}
