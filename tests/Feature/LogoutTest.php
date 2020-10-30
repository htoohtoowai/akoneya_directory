<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Laravel\Passport\Passport;

class LogoutTest extends TestCase
{
   /**
    *@test
    */
    public function logoutSuccessfully(){
        
        \Artisan::call('passport:install');

        $user =User::create([
            'name' =>  config('mock_data.name'),
            'email'=>  config('mock_data.email'),
            'password'=>bcrypt(config('mock_data.emailLoginType')),
            'login_type'=> config('mock_data.emailLoginType'),
            'active_status'=>"active"
        ]);

        Passport::actingAs($user);

        $token = $user->createToken('my-oauth-client-name')->accessToken; 

        $headers = [ 'Accept' => 'application/json','Authorization' => 'Bearer $token'];
        $logout_data = ['user_id' => $user->id];

        $this->json('POST', 'api/logout', $logout_data, $headers)
            ->assertStatus(200); 
    }
}
