<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class DeleteProfessionalTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_deletepro()
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
            "where": [
                {
                    "id": "771"
                }
            ]
        }';
        
        $array = json_decode($json, true);
        

        $route = route('delete-datatable.api', $array);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('DELETE', $route);
        

        $response->assertStatus(200);
    }
}
