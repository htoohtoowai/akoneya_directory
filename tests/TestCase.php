<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Hotel;
use App\Models\Holiday;
use App\Models\Township;
use App\Models\TravelBlog;
use App\Models\TravelSavedBlog;
use App\Models\FoodBlog;
use App\Models\FoodBlogCategory;
use App\Models\FoodBlogMedia;
use App\Models\FoodSavedBlog;
use App\Models\PostalCode;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->successStatusCode = config('http_status.success');
        $this->badRequestStatusCode = config('http_status.badRequest');
        $this->successMsg = config('message.successMsg');
        $this->notFoundMsg = config('message.notFoundMsg');
        $this->deleteMsg = config('message.deleteSuccessMsg');
        $this->apiKeyToken =  $this->setOpenApiAuthToken();
        $this->setUaaAuthHttpFake();
    }
    public function setUaaAuthHttpFake()
    {
        Http::fake([
            // Stub a JSON response for UAA Service Authenticate endpoint
            config('services.uaa_auth_service.url') => Http::response([
                'result' => [
                    'user' => [
                        'id' => 1
                    ]
                ],
                'statusCode' => 200,
                'message' => 'Success.'
            ], 200, ['Headers'])
        ]);
    }
    public function setOpenApiAuthToken()
    {
        $now = Carbon::now()->timestamp;

        $token = config('openapikey.static_auth_key').'.'.$now;

        if (!defined('AES_256_CBC')) {
            define('AES_256_CBC', 'aes-256-cbc');
        }
        return openssl_encrypt($token, AES_256_CBC, config('services.encryptionKey'), 0, config('services.ivKey'));
    }
    public function successJson($resultJson)
    {
        return [
            "result" => $resultJson,
            "statusCode" => $this->successStatusCode,
            "message" =>  $this->successMsg
        ];
    }

    public function successJsonForSavedBlog($successMsg)
    {
        return [
            "result" => null,
            "statusCode" => $this->successStatusCode,
            "message" =>  $successMsg
        ];
    }

    public function deleteSuccessJson($resultJson)
    {
        return [
            "result" => $resultJson,
            "statusCode" => $this->successStatusCode,
            "message" =>  $this->deleteMsg
        ];
    }

    public function failedJson($resultJson)
    {
        return [
            "result" => $resultJson,
            "statusCode" => $this->badRequestStatusCode,
            "message" =>  $this->notFoundMsg
        ];
    }

    public function createUser()
    {
        return User::create([
            'name' => config('mock_data.name'),
            'email' => config('mock_data.email'),
            'login_type' => config('mock_data.emailLoginType'),
            'active_status' => "active",
            'password' => bcrypt(config('mock_data.password'))
        ]);
    }

    public function createPersonalInformation($userId)
    {
        return PersonalInformation::create([
            'client_user_id' => $userId,
            'name' => config('mock_data.name'),
            'email' => config('mock_data.email'),
            'image' => config('mock_data.coverPhotoUrl'),
        ]);
    }

    public function createCategory()
    {
        return Category::create([
            'category_name' => config('mock_data.nameEn'),
            'category_name_mm' => config('mock_data.nameMm'),
            'category_name_zh' => config('mock_data.nameZh'),
            'image' => config('mock_data.fakeLogo'),
            'primary_color_code' => config('mock_data.colorCode'),
            'secondary_color_code' => config('mock_data.colorCode'),
            'deleted_status' => config('mock_data.deleteStatus'),
        ]);
    }

    public function createSubCategory($categoryId)
    {
        $subCategoryName = config('mock_data.subCategoryName');
        return SubCategory::create([
            'subcategory_name' => $subCategoryName,
            'subcategory_name_mm' => $subCategoryName,
            'subcategory_name_zh' => $subCategoryName,
            'service_code' => config('mock_data.serviceCode'),
            'category_id' => $categoryId,
        ]);
    }

    public function createService()
    {
        return Hotel::create([
            'name' => config('mock_data.service_name'),
            'township_id' => config('mock_data.township_id'),
            'zone_id' => config('mock_data.zone_id'),
            'address' => config('mock_data.address'),
            'phone' => config('mock_data.phone')
        ]);
    }

    public function createTownship()
    {
        return Township::create([
            'township_name' => config('mock_data.township_name'),
            'zone_id' => config('mock_data.zone_id')
        ]);
    }

    public function createHoliday()
    {
        return Holiday::create([
            'date' => config('mock_data.date'),
            'description' => config('mock_data.description'),
        ]);
    }

    public function createTravelBlog()
    {
        return TravelBlog::create([
            'zone_id' => config('mock_data.zone_id'),
            'title' => config('mock_data.service_name'),
            'overview' => config('mock_data.service_name'),
            'history' => config('mock_data.description'),
            'main_image' => config('mock_data.fakeLogo'),
            'check_in_point' => config('mock_data.service_name'),
        ]);
    }

    public function createSavedBlog($clientUserId,$travelBlogId)
    {
        return TravelSavedBlog::create([
            'client_user_id' => $clientUserId,
            'travel_blog_id' => $travelBlogId,
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }

    public function createFoodBlogCategory()
    {
        return FoodBlogCategory::create([
            'name' => config('mock_data.foodCategoryName'),
            'name_zh' => config('mock_data.foodCategoryName'),
            'name_mm' => config('mock_data.foodCategoryName')

        ]);
    }
    public function createFoodBlog($categoryId)
    {
        return FoodBlog::create([
            'title' => config('mock_data.foodTitle'),
            'title_mm' => config('mock_data.foodTitle'),
            'title_zh' => config('mock_data.foodTitle'),
            'category_id' => $categoryId,
            'ingredients' => config('mock_data.ingredients'),
            'ingredients_mm' => config('mock_data.ingredients_mm'),
            'ingredients_zh' => config('mock_data.ingredients_zh'),
            'directions' => config('mock_data.directions'),
            'directions_mm' => config('mock_data.directions_mm'),
            'directions_zh' => config('mock_data.directions_zh'),
            'note' => config('mock_data.note'),
            'note_mm' => config('mock_data.note_mm'),
            'note_zh' => config('mock_data.note_zh'),
            'publish_status' => config('mock_data.publish_status'),
            'credit' => config('mock_data.credit')
        ]);
    }

    public function createFoodBlogMedia($foodId)
    {
        return FoodBlogMedia::create([
            'food_id' => $foodId,
            'media_path' => config('mock_data.fakeLogo'),
        ]);
    }

    public function createSavedFoodBlog($clientUserId,$foodBlogId)
    {
        return FoodSavedBlog::create([
            'client_user_id' => $clientUserId,
            'food_id' => $foodBlogId
        ]);
    }

    public function createPostalCode($zoneId, $townshipId)
    {
        return PostalCode::create([
            'zone_id' => $zoneId,
            'directory_township_id' => $townshipId,
            'area_name' => config('mock_data.areaName'),
            'area_postal_code' => config('mock_data.postalCode')
        ]);
    }

    /**
     * Assert that the response has an bad request status code.
     *
     * @return $this
     */
    public function assertBadRequest($actual)
    {
        self::assertSame(
            400,
            $actual,
            "Response status code [{$actual}] is not an bad request status code."
        );

        return $this;
    }

    public function badRequestJsonStructure()
    {
        return [
            "result" => null,
            "statusCode" => config('http_status.badRequest'),
        ];
        $this->setUaaAuthHttpFake();
    }
}
