<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Township;

class TownshipTest extends TestCase
{
    public function  setUp(): void
    {
        parent::setUp();
        $this->township = $this->createTownship();
    }

    public function createTownship()
    {
        return Township::create([
            'township_name' => config('mock_data.township_name'),
            'zone_id' => config('mock_data.zone_id')
        ]);
    }
    
    public function testTownshipListByZoneIdSuccessfully()
    {
        $zoneId = config('mock_data.zone_id');

        $response = $this->get("/api/zones/$zoneId/townships");
        $response->assertOk();
        $response->assertJsonStructure([
            "result" => [
                "townships"
            ],
            "statusCode",
            "message",
        ]);
        $response->assertJson([
            "result" => [
                "townships" => [
                    [
                        "id" => $this->township->id,
                        "name" => $this->township->township_name
                    ]
                ]
            ],
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }

    public function testEmptyTownshipListByZoneId()
    {
        $zoneId = 1;

        $response = $this->get("/api/zones/$zoneId/townships");
        $response->assertOk();
        $response->assertJsonStructure([
            "result" => [
                "townships"
            ],
            "statusCode",
            "message",
        ]);
        $response->assertJson([
            "result" => [
                "townships" => []
            ],
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }
}
