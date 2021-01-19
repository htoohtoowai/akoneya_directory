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
        $response = $this->get("/api/v1.0/holidays?year=2020&month=10",['Accept' => 'application/json','Api-Key' => $this->apiKeyToken]);
        $response->assertOk();
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
