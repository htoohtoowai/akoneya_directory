<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Hotel;
use App\Models\Holiday;
use App\Models\Township;

trait BaseTestServiceTrait
{
    public function jsonStructure($resultStructure)
    {
        return [
            "result" => $resultStructure,
            "statusCode",
            "message",
        ];
    }

    public function successStatusCode()
    {
        return config('http_status.success');
    }

    public function badRequestStatusCode()
    {
        return config('http_status.badRequest');
    }

    public function successMsg()
    {
        return config('message.successMsg');
    }
    
    public function notFoundMsg()
    {
        return config('message.notFoundMsg');
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

    public function createTownship()
    {
        return Township::create([
            'township_name' => config('mock_data.township_name'),
            'zone_id' => config('mock_data.zone_id')
        ]);
    }

    public function createHoliday()
    {
        return Holiday::create([
            'date' => config('mock_data.date'),
            'description' => config('mock_data.description'),
        ]);
    }
}
