<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Laravel\Passport\Passport;

class ChangePasswordTest extends TestCase
{
    public function createUser()
    {
        $user = User::create([
            'name' => config('mock_data.name'),
            'email' => config('mock_data.email'),
            'login_type' => config('mock_data.emailLoginType'),
            'active_status' => "active",
            'password' => bcrypt(config('mock_data.password'))
        ]);

        return $user;
    }

    public function createPassportToken($user)
    {
        \Artisan::call('passport:install');

        Passport::actingAs($user);

        $token = $user->createToken('my-oauth-client-name')->accessToken;

        return $token;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testChangePasswordSuccess()
    {
        $user = $this->createUser();

        $token = $this->createPassportToken($user);

        $headers = [ 'Accept' => 'application/json','Authorization' => "Bearer $token"];
        
        $response = $this->json('POST', 'api/profile/change_password', [
            'id' => $user->id,
            'currentPassword' => config('mock_data.password'),
            'newPassword'=> config('mock_data.password')."abc",
            'confirmNewPassword'=> config('mock_data.password')."abc"
        ],$headers);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "result",
            "statusCode",
            "message"
        ]);

        $response->assertJson([
            "result" => null,
            "statusCode" => 200,
            "message" =>  "Changed password successfully."
        ]);

        $user->delete();
    }
}
