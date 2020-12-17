<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HolidayTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->holiday = $this->createHoliday();
    }

    public function testHolidaysByYearSuccessfully()
    {
        $response = $this->get("/api/holidays?year=2020&month=10");
        $response->assertOk();
        $response->assertJsonStructure($this->jsonStructure([
            "holidays"
        ]));
        $response->assertJson([
            "result" => [
                "holidays" => [
                    [
                        "date" => $this->holiday->date,
                        "description" => $this->holiday->description   
                    ]
                ]
            ],
            "statusCode" => $this->successStatusCode,
            "message" =>  $this->successMsg
        ]);
    }
}
