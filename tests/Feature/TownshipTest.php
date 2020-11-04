<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Township;

class TownshipTest extends TestCase
{
    public function createTownship($data)
    {
        return Township::create($data);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSubCategories()
    {
        $township = $this->createTownship([
            'township_name' => "Hlaing",
            'zone_id' => config('mock_data.zone_id')
        ]);

        $zoneId = config('mock_data.zone_id');

        $response = $this->get("/api/zones/$zoneId/townships");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "result" => [
                "townships"
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
