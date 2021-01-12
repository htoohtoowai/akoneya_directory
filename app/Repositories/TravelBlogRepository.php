<?php

namespace App\Repositories;

use App\Repositories\ResponseRepository;
use App\Models\TravelBlog;
use App\Models\TravelSavedBlog;
use App\Models\TravelBlogMedia;

use App\Http\Resources\TravelBlogResourceCollection;
use App\Http\Resources\TravelBlogDetailResource;

use App\Exceptions\NotFoundException;

class TravelBlogRepository extends BaseRepository
{
    public function __construct(ResponseRepository $responseRepo)
    {
        $this->responseRepo = $responseRepo;
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
        $this->perPage = config('enums.perPage');
        $this->nextId = null;
        $this->requestAuthEmptyStatus = 0;
    }

    public function getTravelBlogList($filter, $nextId, $clientUserId)
    {
        $travelBlogInformation = [];
        $travelBlogInformationList = new TravelBlogResourceCollection($travelBlogInformation, $this->nextId);

        if ($nextId != "" && $nextId != 'null') {
        
            $travelBlogInformationQuery = TravelBlog::filter($filter)->where('deleted_status', $this->disableDeletedStatus);

            $travelBlogInformation = $this->getDataByNextId('id', $nextId, $travelBlogInformationQuery);
         
            foreach ($travelBlogInformation['result'] as $value) {
                $value->isSaved = $this->isSavedTravelBlog($clientUserId, $value->id);
            }

            $travelBlogInformationList = new TravelBlogResourceCollection($travelBlogInformation['result'], $travelBlogInformation['nextId']);
        }
      
        return $this->responseRepo->successResponse($travelBlogInformationList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function isSavedTravelBlog($clientUserId, $blogId)
    {
        return TravelSavedBlog::where('client_user_id', $clientUserId)->where('travel_blog_id', $blogId)->first() != null;
    }

    public function getDetail($id, $clientUserId)
    {
        $traveBlogInfo = [];
        $travelBlog = TravelBlog::where('id', $id)->where('deleted_status', $this->disableDeletedStatus)->first();
        if (!$travelBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }
        $traveBlogInfo = $travelBlog;
        $traveBlogInfo['mediaList'] = TravelBlogMedia::where('travel_blog_id', $id)->get();
        $traveBlogInfo['isSaved'] = (TravelSavedBlog::where('client_user_id', $clientUserId)->where('travel_blog_id', $id)->first() != null);

        return $this->responseRepo->successResponse(new TravelBlogDetailResource($travelBlog), $this->responseRepo->successStatusCode, trans('message.successMsg'));
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
