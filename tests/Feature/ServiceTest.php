<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->subCategory = $this->createSubCategory(config('mock_data.categoryId'));
        $this->service = $this->createService();
    }
    
    public function testServiceListBySubCategoryIdSuccessfully()
    {
        $subCategoryId = $this->subCategory->id;
        $response = $this->get("/api/subcategories/$subCategoryId/services?nextId=0");
        $response->assertOk();
        $response->assertJsonStructure($this->successJsonStructure([
            "resultCount",
            "data",
            "pagination" => [
                "nextId"
            ]
        ]));
        $response->assertJson($this->successJson(
            [
                "resultCount" => 1,
                "data" => [
                    [
                        "id" => $this->service->id,
                        "name" => $this->service->name,
                        "address" => $this->service->address,
                        "phone" => [$this->service->phone]
                    ]
                ],
                "pagination" => [
                    "nextId" => null
                ]
            ]
        ));
    }

    public function testServiceListBySubCategoryIdNotFound()
    {
        $subCategoryId = 999;
        $response = $this->get("/api/subcategories/$subCategoryId/services?nextId=0");
        $response->assertStatus(config('http_status.badRequest'));
        $this->assertBadRequest($response->getStatusCode());
        $response->assertJsonStructure([
            "result",
            "statusCode",
            "message",
        ]);
        $response->assertJson($this->failedJson(null));
    }
}
