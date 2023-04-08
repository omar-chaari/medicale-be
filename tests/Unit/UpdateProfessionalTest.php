<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class UpdateProfessionalTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_updatepro()
    {


        
        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);

        $content = json_decode($response->getContent());

        $token=$content->token;
        
        $json = '{
            "table": "users",
            "data": {
                "keys": {
                    "id": "111"
                },
                "form_data": {
                    "verification": "1"
                }
            }
        }';
        
        $array = json_decode($json, true);
        

        $route = route('update-datatable.api', $array);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', $route);
        

        $response->assertStatus(200);
    }
}
