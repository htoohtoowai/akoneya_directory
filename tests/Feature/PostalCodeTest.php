<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostalCodeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->township = $this->createTownship();
    }

    public function testGetPostalCodesSuccessfully()
    {
        $zoneId = $this->township->zone_id;
        $postalCode = $this->createPostalCode($zoneId, $this->township->id);
        $response = $this->get("api/v1.0/postalCodes?nextId=0&zoneId=$zoneId",['Accept' => 'application/json','Api-Key' => $this->apiKeyToken]);
        $response->assertOk();        
        $response->assertJson($this->successJson(
            [
                "data" => [
                    [
                        'id' => $postalCode->id,
                        'township' => $this->township->township_name,
                        'area' => $postalCode->area_name,
                        'postalCode' => $postalCode->area_postal_code
                    ]
                ],
                "pagination" => [
                    "nextId" => null
                ]
            ]
        ));
    }

    public function testEmptyPostalCodesByInvalidZoneId()
    {
        $zoneId = 999;
        $response = $this->get("api/v1.0/postalCodes?nextId=0&zoneId=$zoneId",['Accept' => 'application/json','Api-Key' => $this->apiKeyToken]);
        $response->assertOk();
        $response->assertJson($this->successJson(
            [
                "data" => [],
                "pagination" => [
                    "nextId" => null
                ]
            ]
        ));
    }
}
