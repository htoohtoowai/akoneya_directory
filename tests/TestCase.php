<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Hotel;
use App\Models\Holiday;
use App\Models\Township;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->successStatusCode = config('http_status.success');
        $this->badRequestStatusCode = config('http_status.badRequest');
        $this->successMsg = config('message.successMsg');
        $this->notFoundMsg = config('message.notFoundMsg');
    }

    public function successJsonStructure($resultJsonStructure)
    {
        return [
            "result" => $resultJsonStructure,
            "statusCode",
            "message",
        ];
    }

    public function successJson($resultJson)
    {
        return [
            "result" => $resultJson,
            "statusCode" => $this->successStatusCode,
            "message" =>  $this->successMsg
        ];
    }

    public function failedJsonStructure()
    {
        return [
            "result",
            "statusCode",
            "message",
        ];
    }

    public function failedJson($resultJson)
    {
        return [
            "result" => $resultJson,
            "statusCode" => $this->badRequestStatusCode,
            "message" =>  $this->notFoundMsg
        ];
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

    /**
     * Assert that the response has an bad request status code.
     *
     * @return $this
     */
    public function assertBadRequest($actual)
    {
        self::assertSame(
            400, $actual,
            "Response status code [{$actual}] is not an bad request status code."
        );

        return $this;
    }
}
