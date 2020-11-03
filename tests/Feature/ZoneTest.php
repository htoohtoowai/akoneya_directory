<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZoneTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testZoneList()
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
            "statusCode" => config('http_status.success'),
            "message" =>  config('message.successMsg')
        ]);
    }
}
