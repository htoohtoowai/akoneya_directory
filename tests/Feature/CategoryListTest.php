<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function createCategory(){

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

    public function testGetCategoryListSuccessfully()
    {
        $this->createCategory();

        $response = $this->get('api/categories');

        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            "result",
            "statusCode",
            "message",
        ]);
        $response->assertJson([
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }
}
