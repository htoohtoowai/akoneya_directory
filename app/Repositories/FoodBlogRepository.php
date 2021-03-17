<?php

namespace App\Repositories;

use App\Repositories\ResponseRepository;
use App\Models\FoodBlog;
use App\Models\FoodSavedBlog;
use App\Models\FoodBlogMedia;
use App\Http\Resources\FoodBlogResourceCollection;
use App\Http\Resources\FoodBlogDetailResource;
use App\Exceptions\NotFoundException;

class FoodBlogRepository extends BaseRepository
{
    public function __construct(ResponseRepository $responseRepo)
    {
        $this->responseRepo = $responseRepo;
        $this->perPage = config('enums.perPage');
        $this->nextId = null;
        $this->requestAuthEmptyStatus = 0;

    }

    public function getFoodBlogList($filter, $nextId, $clientUserId)
    {
        $foodBlogInformation = [];
        $foodBlogInformationList = new FoodBlogResourceCollection($foodBlogInformation, $this->nextId);

        if ($nextId != "" && $nextId != 'null') {

            $foodBlogInformation = $this->getDataByNextId('id', $nextId, FoodBlog::filter($filter));
                 
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

    public function getFoodBlogDetail($id, $clientUserId)
    {
        $foodBlogInfo = [];
        $foodBlog = FoodBlog::where('id', $id)->first();
        if (!$foodBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        $foodBlogInfo = $foodBlog;
        $foodBlogInfo['mediaList'] = FoodBlogMedia::where('food_id', $id)->get();
        $foodBlogInfo['isSaved'] = (FoodSavedBlog::where('client_user_id', $clientUserId)->where('food_id', $id)->first() != null);

        return $this->responseRepo->successResponse(new FoodBlogDetailResource($foodBlog), $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }
    
    public function checkAuthExistOrNot($request)
    {
       
        if (empty($request->header('Authorization'))) {
            $clientUserId = $this->requestAuthEmptyStatus;
        } else {
            $clientUserId = $this->getUserIdFromToken($request->header('Authorization'));
        }
        return $clientUserId;
    }

    public function getUserIdFromToken($token)
    {
        $encodedStr = explode('.', $token);
        $str = $encodedStr[1];
        $decodedStr =  base64_decode($str);
        $getArray = json_decode($decodedStr, true);
        return $getArray['sub'];
    }

  
}
