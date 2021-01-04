<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TownshipTest extends TestCase
{
    public function  setUp(): void
    {
        parent::setUp();
        $this->township = $this->createTownship();
    }

    public function testTownshipListByZoneIdSuccessfully()
    {
        $zoneId = config('mock_data.zone_id');

        $response = $this->get("/api/v1.0/zones/$zoneId/townships");
        $response->assertOk();
        $response->assertJson($this->successJson(
            [
                "townships" => [
                    [
                        "id" => $this->township->id,
                        "name" => $this->township->township_name
                    ]
                ]
            ]
        ));
    }

    public function testEmptyTownshipListByZoneId()
    {
        $zoneId = 999;

        $response = $this->get("/api/v1.0/zones/$zoneId/townships");
        $response->assertOk();
        $response->assertJson($this->successJson(
            [
                "townships" => []
            ]
        ));
    }
}
