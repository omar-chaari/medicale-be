<?php

namespace Tests\Unit\dossiersmedicaux;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class ModifierConsultationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_modifier_consultation()
    {

        
        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);

        $content = json_decode($response->getContent());
       
        $token = $content->token;

    
        $json = '{
            "table": "consultations",
            "data": {
                "keys": {
                    "id": "9"
                },
                "form_data": {
                    "motif": "Le patient se plaint de douleurs abdominales persistantes depuis environ une semaine",
                    "notes": "Les symptômes actuels suggèrent une possible affection gastro-intestinale. Des investigations supplémentaires seront nécessaires pour confirmer le diagnostic"
                }
            },
            "cmd": ""
        }';
        
        $array = json_decode($json, true);
        

        $route = route('update-datatable.api', $array);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', $route);


        $content = json_decode($response->getContent());
        $response->assertStatus(200);
    }
 
}
