<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\SubCategory;


class SubCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSubCategories()
    {
        $categoryName = config('mock_data.categoryName');
        $category = Category::create([
            'category_name' => $categoryName,
            'category_name_mm' => $categoryName,
            'category_name_zh' => $categoryName,
            'primary_color_code' => config('mock_data.colorCode'),
            'secondary_color_code' => config('mock_data.colorCode'),
        ]);

        $subCategoryName = config('mock_data.subCategoryName');
        SubCategory::create([
            'subcategory_name' => $subCategoryName,
            'subcategory_name_mm' => $subCategoryName,
            'subcategory_name_zh' => $subCategoryName,
            'service_code' => config('mock_data.serviceCode'),
            'category_id' => $category->id,
        ]);

       
        $response = $this->get("/api/categories/$category->id/subCategories");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "result" => [
                "subCategories",
                "pagination"
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
