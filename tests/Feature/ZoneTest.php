<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZoneTest extends TestCase
{
    use BaseTestServiceTrait;

    public function testZoneListSuccessfully()
    {
        $response = $this->get('/api/zones');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "result" => [
                "zones"
            ],
            "statusCode",
            "message",
        ]);

        $response->assertJson([
            "result" => [
                "zones" => [
                    [
                        "id" => config('zones.zoneSelections.1.id'),
                        "name" => config('zones.zoneSelections.1.name')
                    ],
                    [
                        "id" => config('zones.zoneSelections.2.id'),
                        "name" => config('zones.zoneSelections.2.name')
                    ],
                    [
                        "id" => config('zones.zoneSelections.3.id'),
                        "name" => config('zones.zoneSelections.3.name')
                    ]
                    //...more zones list order by name
                ]
            ],
            "statusCode" => $this->successStatusCode(),
            "message" =>  $this->successMsg()
        ]);
    }
}
