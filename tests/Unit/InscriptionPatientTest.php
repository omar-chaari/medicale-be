<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class InscriptionPatientTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register()
    {
        $json = '{
            "first_name": "omar",
            "last_name": "cha",
            "country": "",
            "speciality": "13",
            "phone": "50100100",
            "governorate": "2",
            "email": "test9989@test.com",
            "password": "test9989@test.com",
            "password_confirmation": "test9989@test.com",
            "address": "adresss adress adress"
        }';
        
        $array = json_decode($json, true);
        
        
        $route=route('register-patient.api',$array);
        $response = $this->json('POST', $route);

        

        //$content = json_decode($response->getContent());
        $response->assertStatus(200);
        //$this->assertTrue(true);
    }
}
