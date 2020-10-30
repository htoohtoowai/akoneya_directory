<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\PersonalInformation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase
{
    private $phoneType = "phone";
    private $emailType = "email";
    private $name ="tamron-dev";

    private $email = "hninoowailwin@tamronnetwork.com";
    private $otp ="698388";
    private $password = "123456";
    /** @test */

    public function registerWithPhoneSuccessfully()
    {
        $user = factory(User::class)->create([
            'name' => $this->name,
            'email' => '',
            'phone' => rand(1, 10000000000),
            'otp_code'=> '',
            'otp_attempt_time'=>null,
            'active_status' => 'active',
            'login_type' => $this->phoneType,
            'wrong_time' => null,
            'facebook_id' => null,
            'email_id' => null,
            'apple_id' => null,
            'email_verified_at' => null,
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(10),
        ]);

        $personal_information = PersonalInformation::create([
            'client_user_id' => $user['id'],
            'name' => $user['name'],
            'phone' => $user['phone'],
        
        ]);


        $userData = [
            "type" => $this->phoneType,
            "name" => $this->name,
            "emailOrPhone" => rand(1, 10000000000),
            "password" =>  $user->password,
            "passwordConfirmation" => $user->password
        ];


        $response = $this->json('POST', 'api/register/phone_or_email', $userData);
        $response->assertStatus(201);
    }

    public function registerWithEmailSuccessfully()
    {
        $user = factory(User::class)->create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => '',
            'otp_code'=> '',
            'otp_attempt_time'=>now(),
            'active_status' => 'pending',
            'login_type' => $this->emailType,
            'wrong_time' => null,
            'facebook_id' => null,
            'email_id' => null,
            'apple_id' => null,
            'email_verified_at' => null,
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(10),
        ]);

        $personal_information = PersonalInformation::create([
            'client_user_id' => $user['id'],
            'name' => $user['name'],
            'phone' => $user['phone'],
        
        ]);

        $userData = [
            "type" => $this->emailType,
            "name" => $this->name,
            "emailOrPhone" =>  $this->email,
            "password" => $user->password,
            "passwordConfirmation" => $user->password,
        ];

        $response = $this->json('POST', 'api/register/phone_or_email', $userData);
        $response->assertStatus(201);
    }
    public function checkRegisterWithPhoneSuccessfully()
    {
        $userData = [
           'emailOrPhone' =>$this->phone
       ];
        $this->json('POST', 'api/check_register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    public function checkRegisterWithEmailSuccessfully()
    {
        $userData = [
           'emailOrPhone' =>$this->email
       ];
        $this->json('POST', 'api/check_register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    public function otpVerifySuccess()
    {
        $data =[
           "email" => $this->email,
           "otpCode" => $this->otp
       ];
        $this->json('POST', 'api/otp/verify', $data, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
