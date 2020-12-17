<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TownshipTest extends TestCase
{
    use BaseTestServiceTrait;

    public function  setUp(): void
    {
        parent::setUp();
        $this->township = $this->createTownship();
    }

    public function testTownshipListByZoneIdSuccessfully()
    {
        $zoneId = config('mock_data.zone_id');

        $response = $this->get("/api/zones/$zoneId/townships");
        $response->assertOk();
        $response->assertJsonStructure($this->jsonStructure([
            "townships"
        ]));
        $response->assertJson([
            "result" => [
                "townships" => [
                    [
                        "id" => $this->township->id,
                        "name" => $this->township->township_name
                    ]
                ]
            ],
            "statusCode" => $this->successStatusCode(),
            "message" =>  $this->successMsg()
        ]);
    }

    public function testEmptyTownshipListByZoneId()
    {
        $zoneId = 999;

        $response = $this->get("/api/zones/$zoneId/townships");
        $response->assertOk();
        $response->assertJsonStructure($this->jsonStructure([
            "townships"
        ]));
        $response->assertJson([
            "result" => [
                "townships" => []
            ],
            "statusCode" => $this->successStatusCode(),
            "message" =>  $this->successMsg()
        ]);
    }
}
