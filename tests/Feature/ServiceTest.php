<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SubCategory;
use App\Models\Hotel;

class ServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->subCategory = $this->createSubCategory(config('mock_data.categoryId'));
        $this->service = $this->createService();
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
    
    public function testServiceListBySubCategoryIdSuccessfully()
    {
        $subCategoryId = $this->subCategory->id;
        $response = $this->get("/api/subcategories/$subCategoryId/services?nextId=0");
        $response->assertOk();
        $response->assertJsonStructure([
            "result" => [
                "resultCount",
                "data",
                "pagination" => [
                    "nextId"
                ]
            ],
            "statusCode",
            "message",
        ]);
        $response->assertJson([
            "result" => [
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
            ],
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }

    public function testServiceListBySubCategoryIdNotFound()
    {
        $subCategoryId = 999;
        $response = $this->get("/api/subcategories/$subCategoryId/services?nextId=0");
        $response->assertStatus(config('http_status.badRequest'));
        $response->assertJsonStructure([
            "result",
            "statusCode",
            "message",
        ]);
        $response->assertJson([
            "result" => null,
            "statusCode" => config('http_status.badRequest'),
            "message" =>  config('message.notFoundMsg')
        ]);
    }
}
