<?php

namespace Tests\Unit\dossiersmedicaux;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class ConsulterDossierTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_consulter_dossier()
    {
        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);

        $content = json_decode($response->getContent());
       
        $token = $content->token;

        $route = route('show-record.api', [
            "id" => 766,
            "table" => "patients",
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('GET', $route);


        $content = json_decode($response->getContent());
        //  dd($content);  
        $response->assertStatus(200);
    }
 
}
