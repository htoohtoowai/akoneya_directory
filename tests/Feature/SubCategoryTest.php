<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubCategoryTest extends TestCase
{
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
        $response->assertJsonStructure($this->successJsonStructure([
            "subCategories",
            "pagination" => [
                "nextId"
            ]
        ]));
        $response->assertJson($this->successJson(
            [
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
            ]
        ));
    }

    public function testEmptySubCategoryByCategoryId()
    {
        $categoryId = 999;
        
        $response = $this->get("/api/categories/$categoryId/subCategories?nextId=0");
        $response->assertOk();
        $response->assertJsonStructure($this->successJsonStructure([
            "subCategories",
            "pagination" => [
                "nextId"
            ]
        ]));
        $response->assertJson($this->successJson(
            [
                "subCategories" => [],
                "pagination" => [
                    "nextId" => null
                ]
            ]
        ));
    }
}
