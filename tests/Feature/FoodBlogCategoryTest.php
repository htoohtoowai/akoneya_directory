<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FoodBlogCategoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->createFoodBlogCategory = $this->createFoodBlogCategory();
    }
    public function testFoodBlogCategorySuccessfully()
    {
        $response = $this->get('api/v1.0/foodBlogs/categories', ['Accept' => 'application/json','Api-Key' => $this->apiKeyToken]);
        $response->assertOk();
        $response->assertJson($this->successJson(
            [
                "data" => [
                    [
                        'id' => $this->createFoodBlogCategory->id,
                        'name' => $this->createFoodBlogCategory->name
                    ]
                ]
            ]
        ));
    }
}
