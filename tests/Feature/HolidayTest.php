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
        $response->assertJsonStructure($this->successJsonStructure([
            "holidays"
        ]));
        $response->assertJson($this->successJson(
            [
                "holidays" => [
                    [
                        "date" => $this->holiday->date,
                        "description" => $this->holiday->description   
                    ]
                ]
            ]
        ));
    }
}
