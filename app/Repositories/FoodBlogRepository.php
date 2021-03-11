<?php

namespace App\Repositories;

use App\Repositories\ResponseRepository;
use App\Models\FoodBlog;
use App\Models\FoodSavedBlog;
use App\Models\FoodBlogMedia;
use App\Http\Resources\FoodBlogResourceCollection;
// use App\Http\Resources\FoodBlogDetailResource;
use App\Exceptions\NotFoundException;

class FoodBlogRepository extends BaseRepository
{
    public function __construct(ResponseRepository $responseRepo)
    {
        $this->responseRepo = $responseRepo;
        $this->perPage = config('enums.perPage');
        $this->nextId = null;
    }

    public function getFoodBlogList($filter, $nextId, $clientUserId)
    {
        $foodBlogInformation = [];
        $foodBlogInformationList = new FoodBlogResourceCollection($foodBlogInformation, $this->nextId);

        if ($nextId != "" && $nextId != 'null') {
        
            $foodBlogInformation = $this->getDataByNextId('id', $nextId,FoodBlog::filter($filter));
         
            foreach ($foodBlogInformation['result'] as $value) {
                $value->isSaved = $this->isSavedFoodBlog($clientUserId, $value->id);
            }

            $foodBlogInformationList = new FoodBlogResourceCollection($foodBlogInformation['result'], $foodBlogInformation['nextId']);
        }
      
        return $this->responseRepo->successResponse($foodBlogInformationList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function isSavedFoodBlog($clientUserId, $blogId)
    {
        return FoodSavedBlog::where('client_user_id', $clientUserId)->where('food_id', $blogId)->first() != null;
    }

  
}
