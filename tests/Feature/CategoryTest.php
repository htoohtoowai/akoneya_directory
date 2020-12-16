<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\SubCategory;

class CategoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->category = $this->createCategory();
        $this->createSubCategory($this->category->id);
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
        SubCategory::create([
            'subcategory_name' => $subCategoryName,
            'subcategory_name_mm' => $subCategoryName,
            'subcategory_name_zh' => $subCategoryName,
            'service_code' => config('mock_data.serviceCode'),
            'category_id' => $categoryId,
        ]);
    }

    public function testGetCategoryListSuccessfully()
    {
        $response = $this->get('api/categories?nextId=0');
        $response->assertOk();        
        $response->assertJsonStructure([
            "result",
            "statusCode",
            "message",
        ]);
        $response->assertJson([
            "result" => [
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
            ],
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }
}
