<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Holiday;

class HolidayTest extends TestCase
{
   
    public function setUp(): void
    {
        parent::setUp();
        $this->holiday = $this->createHoliday();
    }

    public function createHoliday()
    {
        return Holiday::create([
            'date' => config('mock_data.date'),
            'description' => config('mock_data.description'),
        ]);
    }

    public function testHolidaysByYearSuccessfully()
    {
        $response = $this->get("/api/holidays?year=2020&month=10");
        $response->assertOk();
        $response->assertJsonStructure([
            "result" => [
                "holidays"
            ],
            "statusCode",
            "message",
        ]);

        $response->assertJson([
            "result" => [
                "holidays" => [
                    [
                        "date" => $this->holiday->date,
                        "description" => $this->holiday->description   
                    ]
                ]
            ],
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }
}
