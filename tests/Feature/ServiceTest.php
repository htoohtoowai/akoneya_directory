<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SubCategory;

class ServiceTest extends TestCase
{
    public function createSubCategory($data)
    {
        return SubCategory::create($data);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testServiceListBySubCategoryId()
    {
        $subCategory = $this->createSubCategory([
            'subcategory_name' => config('mock_data.subCategoryName'),
            'subcategory_name_mm' => config('mock_data.subCategoryName'),
            'category_id' => config('mock_data.categoryId'),
            'service_code' => config('mock_data.serviceCode')
        ]);

        $response = $this->get("/api/subcategories/$subCategory->id/services");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "result" => [
                "data",
                "pagination" => [
                    "perPage",
                    "currentPage",
                    "nextPage"
                ]
            ],
            "statusCode",
            "message",
        ]);

        $response->assertJson([
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }
}
