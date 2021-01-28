<?php
namespace App\Repositories;

use App\PersonalInformation;
use App\Models\TravelBlog;
use App\Models\TravelSavedBlog;
use App\Repositories\ResponseRepository;
use App\Repositories\ShoppingFeedRepository;
use App\Exceptions\NotFoundException;
use App\Http\Resources\SavedBlogListCollection;

class SavedBlogRepository extends BaseRepository
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
        $this->perPage = config('enums.perPage');
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
        return $this->responseRepo->successResponse(null, $this->responseRepo->successStatusCode, trans('message.saveSuccessMsg'));
    }

    public function getSavedBlogList($request)
    {
        $savedBlogInfos = [];
        $savedBlogList = new SavedBlogListCollection($savedBlogInfos, $this->nextId);

        if ($request->nextId != "" && $request->nextId != 'null') {
       
            $savedBlogQuery = $this->savedModel->where($this->clientUserId, $request->auth_user_id);
            
            $savedBlogInfos = $this->getDataByNextId('id', $request->nextId, $savedBlogQuery);
        
            foreach ($savedBlogInfos['result'] as $savedBlogInfo) {
                $savedBlogInfo->travelBlogInfo = $this->travelBlogModel->where('id', $savedBlogInfo->travel_blog_id)->first();
                
                $savedBlogInfo->clientUserInfo = $this->personalInfoModel->where($this->clientUserId, $savedBlogInfo->travelBlogInfo->client_user_id)->first();
            }
            $savedBlogList = new SavedBlogListCollection($savedBlogInfos['result'], $savedBlogInfos['nextId']);
        }

        return $this->responseRepo->successResponse($savedBlogList, $this->responseRepo->successStatusCode, trans('message.successMsg'));
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
