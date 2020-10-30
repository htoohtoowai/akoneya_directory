<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\PersonalInformation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;

class ClientProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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

    public function createPersonalInfo($user)
    {
        $personalInfo = PersonalInformation::create([
            'client_user_id' => $user->id,
            'name' => $user->name,
            'phone' => config('mock_data.phone'),
            'email' => config('mock_data.email'),
            'gender' => config('mock_data.gender'),
            'date_of_birth' => config('mock_data.date_of_birth'),
            'bio' => config('mock_data.bio'),
            'address' => config('mock_data.address'),
        ]);

        return $personalInfo;
    }

    public function createPassportToken($user)
    {
        \Artisan::call('passport:install');

        Passport::actingAs($user);

        $token = $user->createToken('my-oauth-client-name')->accessToken;

        return $token;
    }

    public function testProfileDetailsSuccess()
    {
        $user = $this->createUser();

        $personalInfo = $this->createPersonalInfo($user);

        $token = $this->createPassportToken($user);

        $headers = [ 'Accept' => 'application/json','Authorization' => "Bearer $token"];

        $response = $this->get("api/profile/detail/$user->id",$headers);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "result",
            "statusCode",
            "message"
        ]);

        $response->assertJson([
            "result" => [
                'user' => [
                    'id' => $user->id,
                    'name' => $personalInfo->name,
                    'image' => $personalInfo->image ?? "",
                    'phone' => $personalInfo->phone,
                    'email' => $personalInfo->email,
                    'gender' => $personalInfo->gender,
                    'dateOfBirth' => $personalInfo->date_of_birth,
                    'bio' => $personalInfo->bio,
                    'address' => $personalInfo->address,
                    'loginType' => $user->login_type
                ]
            ],
            "statusCode" => 200,
            "message" => "Success"
        ]);

        $personalInfo->delete();
        $user->delete();
    }

    public function testUploadProfileImageSuccess()
    {
        $user = $this->createUser();

        $personalInfo = $this->createPersonalInfo($user);

        $uploadImage = file_get_contents(public_path('mockdata/img/person.png'));
        $base64String =  base64_encode($uploadImage);

        $token = $this->createPassportToken($user);

        $headers = [ 'Accept' => 'application/json','Authorization' => "Bearer $token"];

        $response = $this->json('POST', '/api/profile/upload', [
            'id' => $personalInfo->client_user_id,
            'image' => $base64String
        ],$headers);

        $personalInfo = PersonalInformation::find($personalInfo->id);
        $personalInfoImage =  explode("/", $personalInfo->image);
        $personalInfoImage = $personalInfoImage[count($personalInfoImage) - 1];

        // Assert the file was stored...
        Storage::disk('public')->assertExists("profile_images/$personalInfoImage");

        $response->assertJson([
            "result" => [
                "profileImage" => $personalInfo->image
            ],
            "statusCode" => 200,
            "message" => "Success"
        ]);

        $personalInfo->delete();
        $user->delete();
        Storage::disk('public')->delete("profile_images/$personalInfoImage");
    }

    public function testProfileDetailsUpdateSuccess()
    {
        $user = $this->createUser();

        $personalInfo = $this->createPersonalInfo($user);

        $token = $this->createPassportToken($user);

        $headers = [ 'Accept' => 'application/json','Authorization' => "Bearer $token"];

        $response = $this->json('PUT', '/api/profile/update', [
            'id' => $personalInfo->client_user_id,
            'name' => $personalInfo->name,
            'gender' => $personalInfo->gender,
            'phone' => $personalInfo->phone,
            'email' => $personalInfo->email,
            'dateOfBirth' => $personalInfo->date_of_birth,
            'bio' => $personalInfo->bio,
            'address' => $personalInfo->address
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
            "message" => "Success"
        ]);

        $personalInfo->delete();
        $user->delete();
    }
}
