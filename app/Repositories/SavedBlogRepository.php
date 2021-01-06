<?php
namespace App\Repositories;

use App\PersonalInformation;
use App\Models\TravelBlog;
use App\Models\TravelSavedBlog;
use App\Repositories\ResponseRepository;
use App\Repositories\ShoppingFeedRepository;
use App\Exceptions\NotFoundException;
use App\Http\Resources\SavedBlogListCollection;

class SavedBlogRepository
{
    public function __construct(
        TravelSavedBlog $savedModel,
        PersonalInformation $personalInfoModel,
        TravelBlog $travelBlogModel,
        ResponseRepository $responseRepo
    ) {
        $this->savedModel = $savedModel;
        $this->personalInfoModel = $personalInfoModel;
        $this->travelBlogModel = $travelBlogModel;
        $this->responseRepo = $responseRepo;
        $this->nextId = null;
        $this->clientUserId = 'client_user_id';
        $this->travelBlogId = 'travel_blog_id';
        $this->deleteStatus = 'deleted_status';
        $this->disableDeletedStatus = config('enums.disableDeletedStatus');
    }

    public function saveBlog($blogId, $clientUserId)
    {
        $travelBlog = $this->travelBlogModel->where($this->deleteStatus, $this->disableDeletedStatus)->find($blogId);
       
        if (!$travelBlog) {
            throw new NotFoundException(trans('message.notFoundMsg'));
        }

        $savedBlogInfo = $this->savedModel->where([[$this->clientUserId, $clientUserId],[$this->travelBlogId, $blogId]])->first();
       
        if (empty($savedBlogInfo)) {
            $this->savedModel->create([
                $this->clientUserId => $clientUserId,
                $this->travelBlogId => $blogId,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        return $this->responseRepo->successResponse(null, $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function getSavedBlogList($request, $perPage)
    {
        if (request()->nextId == "" || request()->nextId == 'null') {
            $savedBlogInfos = [];
        } else {
            $savedBlogInfos = $this->savedModel->where($this->clientUserId, $request['auth_user_id']);
            if ($request['nextId'] != 0) {
                $savedBlogInfos = $savedBlogInfos->where('id', '<=', $request['nextId']);
            }
            $savedBlogInfos = $savedBlogInfos->orderBy('id', 'DESC')->limit($perPage + 1)->get();
            $totalCount = $savedBlogInfos->count();

            if ($totalCount > $perPage) {
                $this->nextId = $savedBlogInfos[$perPage]->id;

                unset($savedBlogInfos[$totalCount - 1]);
            }

            foreach ($savedBlogInfos as $savedBlogInfo) {
                $savedBlogInfo->travelBlogInfo = $this->travelBlogModel->where('id', $savedBlogInfo->travel_blog_id)->first();
                
                $savedBlogInfo->clientUserInfo = $this->personalInfoModel->where($this->clientUserId, $savedBlogInfo->travelBlogInfo->client_user_id)->first();
            }
        }
        return $this->responseRepo->successResponse(new SavedBlogListCollection($savedBlogInfos, $this->nextId), $this->responseRepo->successStatusCode, trans('message.successMsg'));
    }

    public function deleteSavedBlog($travelBlogId, $clientUserId)
    {
        $savedTravelBlogInfos = $this->savedModel->where([[$this->travelBlogId, $travelBlogId],[$this->clientUserId, $clientUserId]])->first();
        
        if (empty($savedTravelBlogInfos)) {
            return $this->responseRepo->failResponse(null, $this->responseRepo->notFoundStatusCode, trans('message.notFoundMsg'));
        }
       
        $this->savedModel->where('id', $savedTravelBlogInfos->id)->delete();

        return $this->responseRepo->successResponse(null, $this->responseRepo->successStatusCode, trans('message.deleteSuccessMsg'));
    }
}
