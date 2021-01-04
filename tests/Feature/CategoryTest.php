<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->category = $this->createCategory();
        $this->createSubCategory($this->category->id);
    }

    public function testGetCategoryListSuccessfully()
    {
        $response = $this->get('api/v1.0/categories?nextId=0');
        $response->assertOk();        
        $response->assertJson($this->successJson(
            [
                "categories" => [
                    [
                        'id' => $this->category->id,
                        'name' => $this->category->category_name,
                        'logo' => getFileUrlFromAkoneyaMedia($this->category->image),
                        'primaryColor' => $this->category->primary_color_code,
                        'secondaryColor' => $this->category->secondary_color_code,
                        'totalContent' => 1
                    ]
                ],
                "pagination" => [
                    "nextId" => null
                ]
            ]
        ));
    }
}
