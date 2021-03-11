<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;
use App\Models\FoodSavedBlog;
use App\Models\FoodBlogMedia;
class FoodBlogTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = JWTAuth::fromUser($this->user);
        $this->headers = ['Accept' => 'application/json','Authorization' => "Bearer $this->token",'Api-Key' => $this->apiKeyToken];
        $this->foodCategory = $this->createFoodBlogCategory();
        $this->foodBlog = $this->createFoodBlog($this->foodCategory->id);
        $this->foodBlogMedia = $this->createFoodBlogMedia($this->foodBlog->id);

    }
    
    public function testGetFoodBlogListSuccessfully()
    {
        $response = $this->get("api/v1.0/foodBlogs?nextId=0", $this->headers);
        $response->assertOk();
        $response->assertJson($this->successJson(
            [
                "data" =>[
                    [
                        "id" => $this->foodBlog->id,
                        "title" => $this->foodBlog->title,
                        "category" => config('mock_data.foodCategoryName'),
                        "mediaUrl" => getFileUrlFromAkoneyaMedia(config('mock_data.fakeLogo')),
                        "isSaved" => (FoodSavedBlog::where('client_user_id', $this->user->id)->where('food_id', $this->foodBlog->id)->first() != null)
                    ]
                ],
                "pagination" => [
                    "nextId" => null
                ]
            ],
            $this->successStatusCode,
            $this->successMsg
        ));
    }

    public function testGetFoodBlogDetailSuccessfully()
    {
        $foodBlogId = $this->foodBlog->id;
        $response = $this->get("api/v1.0/foodBlogs/$foodBlogId", $this->headers);
        $response->assertOk();
        $content = $response->decodeResponseJson();
        $this->assertIsInt($content["result"]["id"]);

        // dd($content);

        $response->assertJson($this->successJson(
            [
                "id" => $this->foodBlog->id,
                "title" => $this->foodBlog->title,
                "category" => [
                        "id"=> $this->foodCategory->id,
                        "name"=> $this->foodCategory->name
                ],
                "ingredient" => config('mock_data.ingredients'),
                "direction" => config('mock_data.directions'),
                "note" => config('mock_data.note'),
                "credit" => config('mock_data.credit'),
                "mediaList" => [
                    [
                        "id" => $content["result"]["mediaList"][0]["id"],
                        "url" => $content["result"]["mediaList"][0]["url"],
                    ]
                ],
                "isSaved" => (FoodSavedBlog::where('client_user_id', $this->user->id)->where('food_id', $this->foodBlog->id)->first() != null)
            ],
            $this->successStatusCode,
            $this->successMsg
        ));
    }
}
