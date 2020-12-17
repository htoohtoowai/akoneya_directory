<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HolidayTest extends TestCase
{
    use BaseCustomTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->holiday = $this->createHoliday();
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
            "statusCode" => $this->successStatusCode(),
            "message" =>  $this->successMsg()
        ]);
    }
}
