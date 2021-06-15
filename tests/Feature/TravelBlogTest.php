<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;
use App\Models\TravelSavedBlog;
use App\Models\TravelBlogMedia;
use App\Http\Resources\TravelBlogMediaResource;

class TravelBlogTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = JWTAuth::fromUser($this->user);
        $this->headers = ['Accept' => 'application/json','Authorization' => "Bearer $this->token",'Api-Key' => $this->apiKeyToken];
        $this->travelBlog = $this->createTravelBlog();
    }
    public function testGetTravelBlogListSuccessfully()
    {
        $response = $this->get("api/v1.0/travelBlogs?nextId=0", $this->headers);
        $response->assertOk();
        $response->assertJson($this->successJson(
            [
                "data" =>[
                    [
                        "id" => $this->travelBlog->id,
                        "title" => $this->travelBlog->title,
                        "location" => trans('zones.zoneSelections.'.$this->travelBlog->zone_id.'.name'),
                        "photo" => getFileUrlFromAkoneyaMedia($this->travelBlog->main_image),
                        "isSaved" => (TravelSavedBlog::where('client_user_id', $this->user->id)->where('travel_blog_id', $this->travelBlog->id)->first() != null)
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
    public function testGetDetailOfTravelBlogSuccessfully()
    {
        $mediaList = TravelBlogMedia::where('travel_blog_id', $this->travelBlog->id)->get();
        $response = $this->get("api/v1.0/travelBlogs/".$this->travelBlog->id, $this->headers);
        $response->assertOk();
        $response->assertJson($this->successJson(
            [
                "id" => $this->travelBlog->id,
                "title" => $this->travelBlog->title,
                "location" => trans('zones.zoneSelections.'.$this->travelBlog->zone_id.'.name'),
                "photo" => getFileUrlFromAkoneyaMedia($this->travelBlog->main_image),
                "overView" => $this->travelBlog->overview,
                "history" => $this->travelBlog->history,
                "checkInPoint" => $this->travelBlog->check_in_point,
                "mediaList" => $mediaList->count() == 0 ? [] : TravelBlogMediaResource::collection($mediaList),
                "isSaved" => (TravelSavedBlog::where('client_user_id', $this->user->id)->where('travel_blog_id', $this->travelBlog->id)->first() != null)
                                    
                            
            ],
            $this->successStatusCode,
            $this->successMsg
        ));
    }
    public function testGetDetailOfTravelBlogWhenInvalidBlogId()
    {
        $response = $this->get("api/v1.0/travelBlogs/100000000000", $this->headers);
        $response->assertStatus($this->badRequestStatusCode);
        $response->assertJson($this->failedJson(null));
    }
}
