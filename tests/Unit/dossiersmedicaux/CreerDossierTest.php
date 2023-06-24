<?php

namespace Tests\Unit\dossiersmedicaux;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class CreerDossierTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_creer_dossier()
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
            "table": "patients",
            "data": {
                "keys": {
                    "id": 1
                },
                "form_data": {
                    "birthday": "2023-06-14",
                    "sexe": "h",
                    "first_name": "Amir",
                    "last_name": "Chaaben",
                    "address": "237 rue Cherif Idrisi Sakiet ezzit",
                    "phone": "50657470",
                    "allergies": null,
                    "maladies_chroniques": null,
                    "notes_supplementaires": null,
                    "regime": null,
                    "id_unique": null
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
