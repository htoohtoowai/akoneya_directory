<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class ForgetPasswordTest extends TestCase
{   
    protected $enableActive = 'active';

    public function createUser(){

        $user =User::create([
            'name' =>  config('mock_data.name'),
            'email'=>  config('mock_data.email'),
            'password'=>bcrypt(config('mock_data.emailLoginType')),
            'login_type'=> config('mock_data.emailLoginType'),
            'active_status'=>"active"
        ]);

       
    }

    /**
    *@test
    */
    public function forgetPasswordSuccessfully()
    {
        
        $this->createUser();

        $userData = [
            "emailOrPhone" => config('mock_data.email')
        ];

        $this->json('POST', 'api/forget/forget_password', $userData, ['Accept' => 'application/json'])
             ->assertStatus(200)
             ->assertJson([
                "result" => [
                    "isRegistered"=>true
                ],
                "statusCode"=> config('http_status.success'),
                "message"=> config('message.successMsg')
        ]);
    }
      /**
    *@test
    */
    public function forgetPasswordFailed()
    {
        $this->createUser();

        $userData = [
            "emailOrPhone" =>  config('mock_data.unknownEmail')
        ];

        $this->json('POST', 'api/forget/forget_password',  $userData, ['Accept' => 'application/json'])
             ->assertStatus(200)
             ->assertJson([
                "result" => [
                    "isRegistered"=>false
                ],
                "statusCode"=> config('http_status.success'),
                "message"=> config('message.accountExist')
        ]);
    }
    /**
    *@test
    */
    public function changePasswordSuccessfully()
    {

        $this->createUser();

        $userData = [
            "emailOrPhone" =>  config('mock_data.email'),
            "password" =>  config('mock_data.password'),
            "passwordConfirmation" =>  config('mock_data.password')

        ];

        $this->json('POST', 'api/forget/change_password', $userData, ['Accept' => 'application/json'])
             ->assertStatus(200);
    }
}
