<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Holiday;

class HolidayTest extends TestCase
{
   
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHolidaysByYear()
    {
        Holiday::create([
            'date' => config('mock_data.date'),
            'description' => config('mock_data.description'),
        ]);

        $response = $this->get("/api/holidays?year=2020&page=1");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "result" => [
                "holidays",
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
