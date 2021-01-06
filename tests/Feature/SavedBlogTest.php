<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;

class SavedBlogTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = JWTAuth::fromUser($this->user);
        $this->headers = ['Accept' => 'application/json','Authorization' => "Bearer $this->token"];
        $this->travelBlog = $this->createTravelBlog();
        $this->savedBlog = $this->createSavedBlog($this->travelBlog->id, $this->user->id);
    }
    
    public function testSaveTravelBlogSuccessfully()
    {
        $travelBlogId = $this->travelBlog->id;
        $response = $this->get("api/v1.0/travelBlogs/$travelBlogId/save", $this->headers);
        $response->assertOk();
        $response->assertJson($this->successJson(null));
    }

    public function testSaveTravelBlogFailWhenBlogIdIsInvalid()
    {
        $response = $this->get("api/v1.0/travelBlogs/22215654556/save", $this->headers);
        $response->assertStatus($this->badRequestStatusCode);
        $response->assertJson($this->failedJson(null));
    }

    public function testGetSavedBlogListSuccessfully()
    {
        $response = $this->get("api/v1.0/savedTravelBlog?nextId=0", $this->headers);

        $response->assertOk();

        $response->assertJson($this->successJson(
            [
                "data" =>[
                    [
                        "savedBlogId" => $this->savedBlog->id,
                        "blogId"=> $this->travelBlog->id,
                        "title" => $this->travelBlog->title,
                        "photo" => getFileUrlFromAkoneyaMedia($this->travelBlog->main_image),
                    ]
                ],
                "pagination" => [
                    "nextId" => null
                ]
            ],
            $this->successStatusCode,
            $this->successMsg
        ));
    }

    public function testDeleteSavedBlogSuccessfully()
    {
        $response = $this->json('Delete', 'api/v1.0/savedTravelBlog/'.$this->savedBlog->travel_blog_id, [], $this->headers);

        $response->assertOk();

        $response->assertJson(
            $this->deleteSuccessJson(null)
        );
    }

    public function testDeleteSavedBlogFailedWhenSavedBlogIdIsInvalid()
    {
        $response = $this->json('Delete', 'api/v1.0/savedTravelBlog/1254646', [], $this->headers);

        $response->assertStatus($this->badRequestStatusCode);

        $response->assertJson($this->failedJson(null));
    }
}
