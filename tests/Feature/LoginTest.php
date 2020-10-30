<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    /** @test */

    public function loginWithPhoneSuccessfully()
    {
        $userData = [
            "loginType" => config('mock_data.phoneLoginType'),
            "phone" => config('mock_data.phone'),
            "password" => bcrypt(config('mock_data.password'))
        ];

        $response = $this->json('POST', 'api/login', $userData);
        $response->assertStatus(200);
    }
    public function loginWithEmailSuccessfully()
    {
        $userData = [
            "loginType" =>  config('mock_data.emailLoginType'),
            "email" => config('mock_data.loginEmail'),
            "password" => bcrypt(config('mock_data.password'))
        ];

        $response = $this->json('POST', 'api/login', $userData);
        $response->assertStatus(200);
    }
    public function loginWithFacebookSuccessfully()
    {
        $userData = [
            "loginType" => config('mock_data.facebookLoginType'),
            "name" => config('mock_data.name'),
            "image" => "",
            "email" => config('mock_data.emailLoginType'),
            "facebookId" => config('mock_data.socialId')
        ];
        $response = $this->json('POST', 'api/login', $userData);
        $response->assertStatus(200);
    }
    public function loginWithGoogleSuccessfully()
    {
        $userData = [
            "loginType" =>  config('mock_data.googleLoginType'),
            "name" => config('mock_data.name'),
            "image" => "",
            "email" => config('mock_data.loginEmail'),
            "emailId" => config('mock_data.socialId')
        ];
        $response = $this->json('POST', 'api/login', $userData);
        $response->assertStatus(200);
    }
    public function loginWithAppleSuccessfully()
    {
        $userData = [
            "loginType" => config('mock_data.appleLoginType'),
            "name" => config('mock_data.name'),
            "image" => "",
            "email" => config('mock_data.loginEmail'),
            "emailId" => config('mock_data.socialId')
        ];
        $response = $this->json('POST', 'api/login', $userData);
        $response->assertStatus(200);
    }
}
