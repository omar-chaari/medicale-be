<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class listPatientsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_list_patients()
    {

        $route = route('login-admin.api', [
            "email" => "admin@test.com",
            "password" => "admin@test.com"

        ]);
        $response = $this->json('POST', $route);

        $content = json_decode($response->getContent());

        $token = $content->token;


        $route = route('list-datatable.api', [
            "tableID" => "patients",
            "results_per_page" => 10,
            "page" => 0
        ]);
        $response = $this->json('GET', $route);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('GET', $route);


        $content = json_decode($response->getContent());

        $response->assertStatus(200);
    }
}
