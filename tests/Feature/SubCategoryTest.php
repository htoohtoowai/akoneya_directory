<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubCategoryTest extends TestCase
{
    use BaseTestServiceTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = $this->createCategory();
        $this->subCategory = $this->createSubCategory($this->category->id);
    }

    public function testSubCategoryByCategoryIdSuccessfully()
    {
        $categoryId = $this->category->id;
        
        $response = $this->get("/api/categories/$categoryId/subCategories?nextId=0");
        $response->assertOk();
        $response->assertJsonStructure($this->jsonStructure([
            "subCategories",
            "pagination" => [
                "nextId"
            ]
        ]));
        $response->assertJson([
            "result" => [
                "subCategories" => [
                    [
                        "id" => $this->subCategory->id,
                        "name" => $this->subCategory->subcategory_name,
                        "totalContent" => 0
                    ]
                ],
                "pagination" => [
                    "nextId" => null
                ]
            ],
            "statusCode" => $this->successStatusCode(),
            "message" =>  $this->successMsg()
        ]);
    }

    public function testEmptySubCategoryByCategoryId()
    {
        $categoryId = 999;
        
        $response = $this->get("/api/categories/$categoryId/subCategories?nextId=0");
        $response->assertOk();
        $response->assertJsonStructure($this->jsonStructure([
            "subCategories",
            "pagination" => [
                "nextId"
            ]
        ]));
        $response->assertJson([
            "result" => [
                "subCategories" => [],
                "pagination" => [
                    "nextId" => null
                ]
            ],
            "statusCode" => $this->successStatusCode(),
            "message" =>  $this->successMsg()
        ]);
    }
}
